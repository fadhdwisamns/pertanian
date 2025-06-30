<?php

namespace App\Http\Controllers;

use App\Models\LaporanMasalah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanMasalahController extends Controller
{
    /**
     * Menampilkan daftar laporan masalah.
     * Admin melihat semua, Petani hanya melihat miliknya.
     */
    public function index()
    {
        $query = LaporanMasalah::with('user')->latest();

        // Jika user bukan Admin, filter hanya laporan miliknya
        if (!Auth::user()->hasRole('Admin')) {
            $query->where('user_id', Auth::id());
        }

        $laporanMasalah = $query->paginate(10);

        return view('laporan-masalah.index', compact('laporanMasalah'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        return view('laporan-masalah.create');
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'kategori_masalah' => 'required|string|max:255',
            'deskripsi_masalah' => 'required|string',
            'foto_masalah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('foto_masalah')) {
            $data['foto_masalah'] = $request->file('foto_masalah')->store('foto_laporan_masalah', 'public');
        }

        LaporanMasalah::create($data);

        return redirect()->route('laporan-masalah.index')
            ->with('success', 'Laporan permasalahan berhasil dikirim.');
    }

    /**
     * Menampilkan detail satu laporan.
     */
    public function show(LaporanMasalah $laporanMasalah)
    {
        // Otorisasi: Admin bisa lihat semua, Petani hanya bisa lihat miliknya
        if (!Auth::user()->hasRole('Admin') && $laporanMasalah->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('laporan-masalah.show', compact('laporanMasalah'));
    }

    /**
     * Menampilkan form edit (tidak digunakan untuk sekarang, fokus pada update status).
     */
    public function edit(LaporanMasalah $laporanMasalah)
    {
        // Anda bisa membuat view edit jika diperlukan
        abort(404);
    }

    /**
     * Memperbarui laporan (khususnya untuk update status oleh Admin).
     */
    public function update(Request $request, LaporanMasalah $laporanMasalah)
    {
        // Hanya Admin yang bisa update status
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate([
            'status' => 'required|in:Dikirim,Diproses,Selesai',
        ]);

        $laporanMasalah->update(['status' => $request->status]);

        return redirect()->route('laporan-masalah.show', $laporanMasalah)
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Menghapus laporan masalah.
     */
    public function destroy(LaporanMasalah $laporanMasalah)
    {
        // Otorisasi: Admin atau pemilik laporan yang bisa menghapus
        if (!Auth::user()->hasRole('Admin') && $laporanMasalah->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        
        // Hapus foto dari storage jika ada
        if ($laporanMasalah->foto_masalah) {
            Storage::disk('public')->delete($laporanMasalah->foto_masalah);
        }

        $laporanMasalah->delete();

        return redirect()->route('laporan-masalah.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}

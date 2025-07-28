<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class KelompokTaniController extends Controller
{
    public function index()
    {
        $kelompokTani = KelompokTani::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.kelompok-tani.index', compact('kelompokTani'));
    }
    public function create()
    {
        $defaultLocation = [-0.5336, 101.4452];

        return view('pages.kelompok-tani.create', compact('defaultLocation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'nama_kelompok' => 'required|string|max:255',
            'alamat_sekretariat' => 'required|string',
            'tahun_berdiri' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'komoditas_unggulan' => 'required|string|max:255',
            'ketua_kelompok' => 'required|string|max:255',
            'kelas_kemampuan' => 'required|string|max:255',
            'sub_sektor' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'foto_lokasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::id();

        if ($request->hasFile('foto_lokasi')) {
            $data['foto_lokasi'] = $request->file('foto_lokasi')->store('foto_kelompok_tani', 'public');
        }

        KelompokTani::create($data);

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil ditambahkan.');
    }
    public function show(KelompokTani $kelompokTani)
    {
        if ($kelompokTani->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE DATA INI.');
        }
    }

    public function edit(KelompokTani $kelompokTani)
    {
       if ($kelompokTani->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE DATA INI.');
        }
    }

     public function update(Request $request, KelompokTani $kelompokTani)
    {

        if ($kelompokTani->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE DATA INI.');
        }

        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'nama_kelompok' => 'required|string|max:255',
            'alamat_sekretariat' => 'required|string',
            'tahun_berdiri' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'komoditas_unggulan' => 'required|string|max:255',
            'ketua_kelompok' => 'required|string|max:255',
            'kelas_kemampuan' => 'required|string|max:255',
            'sub_sektor' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'foto_lokasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kelompokTani->update($request->all());

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil diperbarui.');
    }

    public function destroy(KelompokTani $kelompokTani)
    {
        // MODIFIKASI: Pastikan user hanya bisa menghapus datanya sendiri
        if ($kelompokTani->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE DATA INI.');
        }

        $kelompokTani->delete();

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil dihapus.');
    }

    public function report()
    {
        // MODIFIKASI: Ambil data unik (tahun, desa) hanya dari data milik user
        $baseQuery = KelompokTani::where('user_id', Auth::id());

        $tahuns = (clone $baseQuery)->select('tahun_berdiri')->distinct()->orderBy('tahun_berdiri', 'desc')->pluck('tahun_berdiri');
        $desas = (clone $baseQuery)->select('desa')->distinct()->orderBy('desa', 'asc')->pluck('desa');

        return view('pages.kelompok-tani.report', compact('tahuns', 'desas'));
    }

    public function cetakPdf(Request $request)
    {
        // MODIFIKASI: Mulai query dasar dengan memfilter berdasarkan user_id
        $query = KelompokTani::where('user_id', Auth::id());

        $tahun = $request->input('tahun');
        $desa = $request->input('desa');

        if ($tahun) {
            $query->where('tahun_berdiri', $tahun);
        }

        if ($desa) {
            $query->where('desa', $desa);
        }

        $kelompokTani = $query->get();
        $filters = $request->only(['tahun', 'desa']);
        $pdf = PDF::loadView('pages.kelompok-tani.pdf', compact('kelompokTani', 'filters'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-kelompok-tani.pdf');
    }
}
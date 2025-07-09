<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class KelompokTaniController extends Controller
{
    public function index()
    {
        $kelompokTani = KelompokTani::latest()->paginate(10);
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

        if ($request->hasFile('foto_lokasi')) {
            $data['foto_lokasi'] = $request->file('foto_lokasi')->store('foto_kelompok_tani', 'public');
        }

        KelompokTani::create($data);

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil ditambahkan.');
    }

    public function show(KelompokTani $kelompokTani)
    {
        return view('pages.kelompok-tani.show', compact('kelompokTani'));
    }

    public function edit(KelompokTani $kelompokTani)
    {
        return view('pages.kelompok-tani.edit', compact('kelompokTani'));
    }

    public function update(Request $request, KelompokTani $kelompokTani)
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

        $kelompokTani->update($request->all());

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil diperbarui.');
    }


    public function destroy(KelompokTani $kelompokTani)
    {
        $kelompokTani->delete();

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data Kelompok Tani berhasil dihapus.');
    }

    /**
     * Menampilkan halaman report dengan form filter.
     */
    public function report()
    {
        // Ambil data unik untuk filter dropdown
        $tahuns = KelompokTani::select('tahun_berdiri')->distinct()->orderBy('tahun_berdiri', 'desc')->pluck('tahun_berdiri');
        $desas = KelompokTani::select('desa')->distinct()->orderBy('desa', 'asc')->pluck('desa');

        // Kirim data ke view
        return view('pages.kelompok-tani.report', compact('tahuns', 'desas'));
    }

    /**
     * Membuat dan mengunduh laporan dalam format PDF berdasarkan filter.
     */
    public function cetakPdf(Request $request)
    {
        // Mulai query dasar
        $query = KelompokTani::query();

        // Ambil nilai filter dari request
        $tahun = $request->input('tahun');
        $desa = $request->input('desa');

        // Terapkan filter jika ada nilainya
        if ($tahun) {
            $query->where('tahun_berdiri', $tahun);
        }

        if ($desa) {
            $query->where('desa', $desa);
        }

        // Eksekusi query untuk mendapatkan data yang sudah difilter
        $kelompokTani = $query->get();
        
        // Simpan nilai filter untuk ditampilkan di header PDF
        $filters = $request->only(['tahun', 'desa']);

        // Buat PDF dengan data yang sudah difilter
        $pdf = PDF::loadView('pages.kelompok-tani.pdf', compact('kelompokTani', 'filters'));

        // Atur orientasi kertas
        $pdf->setPaper('a4', 'landscape');

        // Tampilkan atau unduh PDF
        return $pdf->stream('laporan-kelompok-tani.pdf');
    }
}
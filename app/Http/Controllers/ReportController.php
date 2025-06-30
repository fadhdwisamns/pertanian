<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\KelompokTani;
use PDF;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama untuk filter laporan.
     */
    public function index()
    {
        // Ambil data unik untuk filter dropdown
        $desas = KelompokTani::distinct()->pluck('desa');
        $tahuns = KelompokTani::select('tahun_berdiri')->distinct()->orderBy('tahun_berdiri', 'desc')->pluck('tahun_berdiri');
        return view('reports.index', compact('desas', 'tahuns'));
    }

    /**
     * Membuat dan mencetak laporan data lahan berdasarkan filter.
     */
    public function cetakLahan(Request $request)
    {
        $request->validate([
            'tahun' => 'nullable|integer',
            'desa' => 'nullable|string',
        ]);

    
       $query = Lahan::with(['user', 'user.kelompokTanis']); // Gunakan nama relasi yang baru


        // Terapkan filter jika ada
        // INI BLOK KODE PENGGANTINYA

        $tahun = $request->input('tahun');
        $desa = $request->input('desa');

        // Hanya jalankan 'whereHas' jika ada filter tahun atau desa yang dipilih
        if ($tahun || $desa) {
            $query->whereHas('user.kelompokTanis', function ($q) use ($tahun, $desa) {
                // Terapkan filter tahun berdiri jika ada
                if ($tahun) {
                    $q->where('tahun_berdiri', $tahun);
                }

                // Terapkan filter desa jika ada
                if ($desa) {
                    $q->where('desa', $desa);
                }
            });
        }

        $lahans = $query->get();
        $filters = $request->only(['tahun', 'desa']);

        // dd($lahans->toArray()); // Tambahkan ini untuk debugging

        $pdf = PDF::loadView('reports.pdf_lahan', compact('lahans', 'filters'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-data-lahan.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use App\Models\Komoditas;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{ 
    public function index()
    {
        // Data Statistik Universal untuk semua role
        $totalKelompokTani = KelompokTani::count();
        $totalKecamatan = KelompokTani::distinct('kecamatan')->count('kecamatan');
        $totalLuasLahan = Lahan::sum('luas_lahan');
        $totalKomoditas = KelompokTani::distinct('komoditas_unggulan')->count('komoditas_unggulan');

        $user = Auth::user();

        // Kondisi untuk menampilkan data berdasarkan role
        if ($user->hasRole('Admin')) {
            // Data untuk Grafik (Khusus Admin)
            $kelompokPerKecamatan = KelompokTani::select('kecamatan', DB::raw('count(*) as total'))
                ->groupBy('kecamatan')
                ->orderBy('total', 'desc')
                ->get();

            $komoditasPopuler = KelompokTani::select('komoditas_unggulan', DB::raw('count(*) as total'))
                ->groupBy('komoditas_unggulan')
                ->orderBy('total', 'desc')
                ->limit(7)
                ->get();

            return view('dashboard', compact(
                'totalKelompokTani',
                'totalKecamatan',
                'totalLuasLahan',
                'totalKomoditas',
                'kelompokPerKecamatan',
                'komoditasPopuler'
            ));
        } else {
            // Data Peta untuk Petani & Komoditas
            $lahans = Lahan::with('user')->get()->map(function ($lahan) {
                if ($lahan->foto_lahan) {
                    $lahan->foto_url = asset('storage/' . $lahan->foto_lahan);
                } else {
                    $lahan->foto_url = null;
                }
                return $lahan;
            });

            $kelompokTanis = KelompokTani::whereNotNull('latitude')->whereNotNull('longitude')->get();

            return view('dashboard', compact(
                'totalKelompokTani',
                'totalKecamatan',
                'totalLuasLahan',
                'totalKomoditas',
                'lahans', // Data peta untuk view
                'kelompokTanis' // Data peta untuk view
            ));
        }
    }
    
     public function sig()
    {
        // Ambil semua data lahan dan proses untuk menambahkan URL foto
        $lahans = Lahan::with('user')->get()->map(function ($lahan) {
            if ($lahan->foto_lahan) {
                // Buat atribut baru 'foto_url' yang berisi URL lengkap
                $lahan->foto_url = asset('storage/' . $lahan->foto_lahan);
            } else {
                $lahan->foto_url = null;
            }
            return $lahan;
        });

        // Ambil data kelompok tani yang memiliki koordinat
        $kelompokTanis = KelompokTani::whereNotNull('latitude')->whereNotNull('longitude')->get();

        // Kirim kedua data ke view
        return view('dashboard-sig', compact('lahans', 'kelompokTanis'));
    }
}
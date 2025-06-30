<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lahan;
use App\Models\User;
use Illuminate\Http\Request;

class LahanController extends Controller
{
    /**
     * Menampilkan semua data lahan dari semua pengguna.
     */
    public function index()
    {
        // Ambil SEMUA lahan beserta data pemiliknya (user)
        $lahans = Lahan::with('user')->latest()->paginate(15);
        return view('admin.lahan.index', compact('lahans'));
    }

    /**
     * Menampilkan form untuk admin membuat data lahan baru (dan memilih pemiliknya).
     */
    public function create()
    {
        // Ambil semua user dengan peran 'petani' untuk ditampilkan di dropdown
        $petanis = User::role('petani')->get();
        return view('admin.lahan.create', compact('petanis'));
    }

    /**
     * Menyimpan data lahan baru yang dibuat oleh admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'jumlah_produksi' => 'required|string|max:255',
        ]);

        Lahan::create($request->all());

        return redirect()->route('admin.lahan.index')->with('success', 'Data lahan berhasil ditambahkan.');
    }
}
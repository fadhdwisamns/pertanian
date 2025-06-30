<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
// Model User tidak lagi diperlukan untuk dropdown
// use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    public function index()
    {
        // Tidak perlu eager loading 'user' untuk nama petani, tapi tetap berguna untuk info "Diinput Oleh"
        $lahans = Lahan::with('user')->latest()->paginate(10);
        return view('lahan.index', compact('lahans'));
    }

    public function create()
    {
        $defaultLocation = [-0.5336, 101.4452];
        // Tidak perlu lagi mengirim data $users
        return view('lahan.create', compact('defaultLocation'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_petani' => 'required|string|max:255',
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'jumlah_produksi' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_lahan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $dataToSave = $validatedData;
        $dataToSave['user_id'] = Auth::id();

        if ($request->hasFile('foto_lahan')) {
            $dataToSave['foto_lahan'] = $request->file('foto_lahan')->store('foto_lahan', 'public');
        }

        Lahan::create($dataToSave);

        return redirect()->route('lahan.index')->with('success', 'Data lahan berhasil ditambahkan.');
    }

    public function show(Lahan $lahan)
    {
        return view('lahan.show', compact('lahan'));
    }

    public function edit(Lahan $lahan)
    {
        // Tidak perlu lagi mengirim data $users
        return view('lahan.edit', compact('lahan'));
    }

    public function update(Request $request, Lahan $lahan)
    {
        // Perbaiki validasi di sini, hapus 'user_id' dan tambahkan 'nama_petani'
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'jumlah_produksi' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_lahan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto_lahan');

        if ($request->hasFile('foto_lahan')) {
            if ($lahan->foto_lahan) {
                Storage::disk('public')->delete($lahan->foto_lahan);
            }
            $data['foto_lahan'] = $request->file('foto_lahan')->store('foto_lahan', 'public');
        }

        $lahan->update($data);

        return redirect()->route('lahan.index')->with('success', 'Data lahan berhasil diperbarui.');
    }

    public function destroy(Lahan $lahan)
    {
        if ($lahan->foto_lahan) {
            Storage::disk('public')->delete($lahan->foto_lahan);
        }
        $lahan->delete();
        return redirect()->route('lahan.index')->with('success', 'Data lahan berhasil dihapus.');
    }
}

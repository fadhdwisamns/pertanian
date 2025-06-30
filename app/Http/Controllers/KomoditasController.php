<?php

namespace App\Http\Controllers;

use App\Models\Komoditas;
use Illuminate\Http\Request;

class KomoditasController extends Controller
{
    public function index(Request $request)
    {
        
        $komoditas = Komoditas::latest()->paginate(10);
        return view('komoditas.index', compact('komoditas'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'nama_komoditas' => 'required|string|unique:komoditas,nama_komoditas|max:255',
        ]);

        Komoditas::create($request->all());

        return redirect()->route('komoditas.index')->with('success', 'Komoditas berhasil ditambahkan.');
    }

    public function update(Request $request, Komoditas $komodita)
    {
      
        $request->validate([
            'nama_komoditas' => 'required|string|unique:komoditas,nama_komoditas,' . $komodita->id . '|max:255',
        ]);

        $komodita->update($request->all());

        return redirect()->route('komoditas.index')->with('success', 'Komoditas berhasil diperbarui.');
    }

    public function destroy(Komoditas $komodita)
    {
        
        $komodita->delete();
        return redirect()->route('komoditas.index')->with('success', 'Komoditas berhasil dihapus.');
    }
}
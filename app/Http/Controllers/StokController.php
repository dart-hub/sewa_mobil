<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stoks = Stok::with('mobil')->get();
        $mobils = Mobil::all();
        return view('stoks.index', compact('stoks', 'mobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('stoks.index')
                ->with('error', 'Hanya admin yang dapat menambah stok.');
        }
        
        $mobils = Mobil::all();
        return view('stoks.create', compact('mobils'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('stoks.index')
                ->with('error', 'Hanya admin yang dapat menambah stok.');
        }
        
        $request->validate([
            'date' => 'required|date',
            'mobil_id' => 'required|exists:mobils,id',
            'stok' => 'required|integer|min:0',
        ]);

        // Buat entri stok baru
        Stok::create($request->all());

        return redirect()->route('stoks.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stok $stok)
    {
        return view('stoks.show', compact('stok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('stoks.index')
                ->with('error', 'Hanya admin yang dapat mengedit stok.');
        }
        
        $mobils = Mobil::all();
        return view('stoks.edit', compact('stok', 'mobils'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stok $stok)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('stoks.index')
                ->with('error', 'Hanya admin yang dapat mengedit stok.');
        }
        
        $request->validate([
            'date' => 'required|date',
            'mobil_id' => 'required|exists:mobils,id',
            'stok' => 'required|integer|min:0',
        ]);

        $stok->update($request->all());

        return redirect()->route('stoks.index')
            ->with('success', 'Stok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stok $stok)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('stoks.index')
                ->with('error', 'Hanya admin yang dapat menghapus stok.');
        }
        
        $stok->delete();

        return redirect()->route('stoks.index')
            ->with('success', 'Stok berhasil dihapus.');
    }
}

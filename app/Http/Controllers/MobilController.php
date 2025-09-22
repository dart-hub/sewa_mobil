<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::all();
        return view('mobils.index', compact('mobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        return view('mobils.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_type' => 'required|in:reguler,premium',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        Mobil::create($request->all());

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        return view('mobils.show', compact('mobil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mobil $mobil)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        return view('mobils.edit', compact('mobil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mobil $mobil)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        $request->validate([
            'car_name' => 'required|string|max:255',
            'car_type' => 'required|in:reguler,premium',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        $mobil->update($request->all());

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mobil $mobil)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        $mobil->delete();

        return redirect()->route('mobils.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}

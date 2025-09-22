<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\User;
use App\Models\Customer;
use App\Models\Stok;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['customer', 'mobil']);
        
        // Filter berdasarkan tanggal rental
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('rent_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('rent_date', '<=', $request->end_date);
        }
        
        // Urutkan berdasarkan tanggal terbaru
        $transaksis = $query->latest()->get();
        
        return view('transaksis.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin dan kasir bisa mengakses
        if (!Auth::user()->isAdmin() && !Auth::user()->isKasir()) {
            return redirect()->route('transaksis.index')
                ->with('error', 'Hanya admin dan kasir yang dapat menambah transaksi.');
        }
        
        // Mengambil semua mobil
        $mobils = Mobil::all();
        return view('transaksis.create', compact('mobils'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin dan kasir bisa mengakses
        if (!Auth::user()->isAdmin() && !Auth::user()->isKasir()) {
            return redirect()->route('transaksis.index')
                ->with('error', 'Hanya admin dan kasir yang dapat menambah transaksi.');
        }
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'mobil_id' => 'required|exists:mobils,id',
            'rent_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rent_date',
            'number_of_cars' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,lunas',
            'payment_type' => 'required|in:cash,transfer',
        ]);

        // Buat atau temukan customer menggunakan firstOrCreate
        $customer = Customer::firstOrCreate(
            ['phone_number' => $request->customer_phone],
            ['name' => $request->customer_name]
        );
        
        // Hitung total biaya otomatis
        $mobil = Mobil::findOrFail($request->mobil_id);
        $tanggalSewa = Carbon::parse($request->rent_date);
        $tanggalKembali = Carbon::parse($request->return_date);
        $durasi = $tanggalSewa->diffInDays($tanggalKembali) + 1; // +1 karena inklusif hari pertama
        $totalBiaya = $durasi * $mobil->price_per_day * $request->number_of_cars;

        
        // Periksa stok
        $stokTerkini = $mobil->jumlahStokTerkini();
        if ($stokTerkini < $request->number_of_cars) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['number_of_cars' => 'Stok mobil tidak mencukupi. Stok tersedia: ' . $stokTerkini]);
        }
        
        // Tambahkan customer_id dan total biaya ke data yang akan disimpan
        $transaksiData = [
            'customer_id' => $customer->id,
            'mobil_id' => $request->mobil_id,
            'rent_date' => $request->rent_date,
            'return_date' => $request->return_date,
            'number_of_cars' => $request->number_of_cars,
            'payment_status' => $request->payment_status,
            'payment_type' => $request->payment_type,
            'total_cost' => $totalBiaya
        ];
        
        $transaksi = Transaksi::create($transaksiData);
        
        // Kurangi stok mobil
        $this->kurangiStokMobil($mobil, $request->number_of_cars);
        
        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil ditambahkan dengan total biaya: Rp ' . number_format($totalBiaya, 2));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksis.index')
                ->with('error', 'Hanya admin yang dapat mengedit transaksi.');
        }
        
        $mobils = Mobil::all();
        return view('transaksis.edit', compact('transaksi', 'mobils'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('transaksis.index')
                ->with('error', 'Hanya admin yang dapat mengedit transaksi.');
        }
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'mobil_id' => 'required|exists:mobils,id',
            'rent_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rent_date',
            'number_of_cars' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,lunas',
            'payment_type' => 'required|in:cash,transfer',
        ]);

        // Buat atau temukan customer menggunakan firstOrCreate
        $customer = Customer::firstOrCreate(
            ['phone_number' => $request->customer_phone],
            ['name' => $request->customer_name]
        );
        
        // Hitung total biaya otomatis
        $mobil = Mobil::findOrFail($request->mobil_id);
        $tanggalSewa = Carbon::parse($request->rent_date);
        $tanggalKembali = Carbon::parse($request->return_date);
        $durasi = $tanggalSewa->diffInDays($tanggalKembali) + 1; // +1 karena inklusif hari pertama
        $totalBiaya = $durasi * $mobil->price_per_day * $request->number_of_cars;

        
        // Periksa stok (kecuali untuk transaksi yang sedang diedit)
        $stokTerkini = $mobil->jumlahStokTerkini();
        // Tambahkan kembali stok yang sebelumnya dikurangi untuk transaksi ini
        $stokTerkini += $transaksi->number_of_cars;
        
        if ($stokTerkini < $request->number_of_cars) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['number_of_cars' => 'Stok mobil tidak mencukupi. Stok tersedia: ' . $stokTerkini]);
        }
        
        // Tambahkan customer_id dan total biaya ke data yang akan disimpan
        $transaksiData = [
            'customer_id' => $customer->id,
            'mobil_id' => $request->mobil_id,
            'rent_date' => $request->rent_date,
            'return_date' => $request->return_date,
            'number_of_cars' => $request->number_of_cars,
            'payment_status' => $request->payment_status,
            'payment_type' => $request->payment_type,
            'total_cost' => $totalBiaya
        ];
        
        // Kembalikan stok mobil yang sebelumnya dikurangi
        $this->kembalikanStokMobil($mobil, $transaksi->number_of_cars);
        
        // Update transaksi
        $transaksi->update($transaksiData);
        
        // Kurangi stok mobil yang baru
        $this->kurangiStokMobil($mobil, $request->number_of_cars);
        
        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil diperbarui dengan total biaya: Rp ' . number_format($totalBiaya, 2));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Kembalikan stok mobil sebelum menghapus transaksi
        $this->kembalikanStokMobil($transaksi->mobil, $transaksi->number_of_cars);
        
        $transaksi->delete();
        
        return redirect()->route('transaksis.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
    
    /**
     * Kurangi stok mobil
     */
    private function kurangiStokMobil($mobil, $jumlah)
    {
        // Dapatkan stok terkini
        $stokTerkini = $mobil->stokTerkini();
        
        if ($stokTerkini) {
            // Update stok terkini dengan mengurangi jumlah yang diminta
            $stokTerkini->update([
                'stok' => $stokTerkini->stok - $jumlah
            ]);
        } else {
            // Jika belum ada entri stok sama sekali, buat entri stok baru dengan nilai 0 dikurangi jumlah
            Stok::create([
                'date' => now()->toDateString(),
                'mobil_id' => $mobil->id,
                'stok' => -$jumlah
            ]);
        }
    }
    
    /**
     * Kembalikan stok mobil
     */
    private function kembalikanStokMobil($mobil, $jumlah)
    {
        // Dapatkan stok terkini
        $stokTerkini = $mobil->stokTerkini();
        
        if ($stokTerkini) {
            // Update stok terkini dengan menambahkan jumlah yang dikembalikan
            $stokTerkini->update([
                'stok' => $stokTerkini->stok + $jumlah
            ]);
        } else {
            // Jika belum ada entri stok sama sekali, buat entri stok baru dengan nilai jumlah
            Stok::create([
                'date' => now()->toDateString(),
                'mobil_id' => $mobil->id,
                'stok' => $jumlah
            ]);
        }
    }
}

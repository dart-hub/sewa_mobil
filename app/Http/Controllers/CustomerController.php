<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Load relasi transaksis dengan mobil
        $customer->load('transaksis.mobil');
        
        return view('customers.show', compact('customer'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Hanya admin yang bisa mengakses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
        }
        
        // Cek apakah customer memiliki transaksi
        if ($customer->transaksis()->count() > 0) {
            return redirect()->route('customers.index')
                ->with('error', 'Tidak dapat menghapus customer yang memiliki transaksi.');
        }
        
        $customer->delete();
        
        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil dihapus.');
    }
}
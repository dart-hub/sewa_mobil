@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Detail Transaksi</h2>
            <a href="{{ route('transaksis.index') }}" class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Transaksi
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">ID Transaksi</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->id }}</p>
                </div>
                
                {{-- Bagian ini yang diubah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500">Customer</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->customer->name ?? 'Customer ' . $transaksi->customer_id }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500">Nomor Telepon Customer</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->customer->phone_number ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-500">Mobil</label>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->mobil->car_name ?? 'Mobil ' . $transaksi->mobil_id }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Sewa</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->rent_date }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Kembali</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->return_date }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Jumlah Mobil</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $transaksi->number_of_cars }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Harga per Hari</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">Rp {{ number_format($transaksi->mobil->price_per_day ?? 0, 2) }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Durasi Sewa</label>
                        @php
                            $tanggalSewa = \Carbon\Carbon::parse($transaksi->rent_date);
                            $tanggalKembali = \Carbon\Carbon::parse($transaksi->return_date);
                            $durasi = $tanggalSewa->diffInDays($tanggalKembali) + 1;
                        @endphp
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $durasi }} hari</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Total Biaya</label>
                        <p class="mt-1 text-lg font-medium text-gray-900">Rp {{ number_format($transaksi->total_cost, 2) }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Pembayaran</label>
                        <p class="mt-1">
                            @if($transaksi->payment_status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tipe Pembayaran</label>
                        <p class="mt-1">
                            @if($transaksi->payment_type == 'cash')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Cash
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    Transfer
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi</h3>
            <div class="space-y-3">
                @if(Auth::user()->isAdmin())
                <a 
                    href="{{ route('transaksis.edit', $transaksi) }}" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                >
                    <i class="fas fa-edit mr-2"></i>
                    Edit Transaksi
                </a>
                
                <form action="{{ route('transaksis.destroy', $transaksi) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                    >
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Transaksi
                    </button>
                </form>
                @endif
                
                <a 
                    href="{{ route('transaksis.index') }}" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
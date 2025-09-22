@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
        <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang di Sewa Mobil</h1>
        <p class="text-base md:text-lg opacity-90">Sistem manajemen rental mobil yang lengkap dan mudah digunakan</p>
        
        @auth
        <div class="mt-4">
            <p class="text-lg">Halo, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p class="text-sm">Anda login sebagai <strong>{{ Auth::user()->role_label }}</strong></p>
        </div>
        @endauth
        
        @guest
        <div class="mt-4 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-blue-600 font-medium rounded-md hover:bg-blue-50 transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-transparent border-2 border-white text-white font-medium rounded-md hover:bg-white hover:text-blue-600 transition">
                Register
            </a>
        </div>
        @endguest
    </div>
    
    @auth
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-car text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Mobil</h3>
                    <p class="text-gray-500 text-sm">Lihat daftar mobil</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('mobils.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Lihat Mobil <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-warehouse text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Stok</h3>
                    <p class="text-gray-500 text-sm">Lihat stok mobil</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('stoks.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Lihat Stok <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        @if(Auth::user()->isAdmin())
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Transaksi</h3>
                    <p class="text-gray-500 text-sm">Kelola transaksi</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('transaksis.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Kelola Transaksi <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endif
        
        @if(Auth::user()->isKasir())
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Transaksi</h3>
                    <p class="text-gray-500 text-sm">Lihat transaksi</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('transaksis.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Lihat Transaksi <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endif
        
        @if(Auth::user()->isAdmin())
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Tambah Mobil</h3>
                    <p class="text-gray-500 text-sm">Tambah data mobil baru</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('mobils.create') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Tambah Mobil <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endif
        
        @if(Auth::user()->isAdmin())
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500">
                    <i class="fas fa-plus-square text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Tambah Stok</h3>
                    <p class="text-gray-500 text-sm">Tambah stok mobil</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('stoks.create') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Tambah Stok <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endif
        
        @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-800">Tambah Transaksi</h3>
                    <p class="text-gray-500 text-sm">Tambah transaksi baru</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('transaksis.create') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    Tambah Transaksi <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
    @endauth
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-car text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-base md:text-lg font-medium text-gray-500">Total Mobil</h3>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">
                        {{ \App\Models\Mobil::count() }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-warehouse text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-base md:text-lg font-medium text-gray-500">Total Stok</h3>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">
                        {{ \App\Models\Mobil::with('stoks')->get()->sum(function($mobil) {
                            return $mobil->jumlahStokTerkini();
                        }) }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i class="fas fa-exchange-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-base md:text-lg font-medium text-gray-500">Total Transaksi</h3>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">
                        {{ \App\Models\Transaksi::count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    @auth
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-800">Transaksi Terbaru</h2>
            <a href="{{ route('transaksis.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
        
        @if(\App\Models\Transaksi::count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Models\Transaksi::with(['customer', 'mobil'])->latest()->limit(5)->get() as $transaksi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaksi->customer->name ?? 'Customer ' . $transaksi->customer_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->mobil->car_name ?? 'Mobil ' . $transaksi->mobil_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->rent_date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($transaksi->total_cost, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if($transaksi->payment_status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-exchange-alt text-gray-400 text-3xl mb-2"></i>
                <p class="text-gray-500">Belum ada transaksi</p>
            </div>
        @endif
    </div>
    @endauth
</div>
@endsection

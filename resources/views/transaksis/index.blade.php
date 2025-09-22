@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Transaksi</h1>
            @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
            <a href="{{ route('transaksis.create') }}" 
               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Tambah Transaksi
            </a>
            @endif
        </div>

        <!-- Form Filter -->
        <div class="bg-white shadow sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Filter Transaksi</h3>
                <form method="GET" action="{{ route('transaksis.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            value="{{ request('start_date') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                        >
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            value="{{ request('end_date') }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                        >
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        
                        <a 
                            href="{{ route('transaksis.index') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <i class="fas fa-undo mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Mobil</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($transaksis as $transaksi)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->customer->name ?? 'Customer ' . $transaksi->customer_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->mobil->car_name ?? 'Mobil ' . $transaksi->mobil_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->rent_date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->return_date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->number_of_cars }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($transaksi->total_cost, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    @if($transaksi->payment_status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('transaksis.show', $transaksi) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                    <a href="{{ route('transaksis.edit', $transaksi) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transaksis.destroy', $transaksi) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-3 text-center text-sm text-gray-500">
                                    Tidak ada data transaksi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

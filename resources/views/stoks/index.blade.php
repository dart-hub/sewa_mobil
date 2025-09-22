@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Stok</h1>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('stoks.create') }}" 
               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Tambah Stok
            </a>
            @endif
        </div>

        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga per Hari</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($stoks as $stok)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $stok->date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stok->mobil->car_name ?? 'Mobil #' . $stok->mobil_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($stok->mobil->price_per_day ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $stok->stok }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('stoks.show', $stok) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                    <a href="{{ route('stoks.edit', $stok) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('stoks.destroy', $stok) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus stok ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                                    Tidak ada data stok.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($mobils->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Stok Terkini per Mobil</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga per Hari</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Terkini</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($mobils as $mobil)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mobil->car_name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($mobil->price_per_day, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $mobil->jumlahStokTerkini() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

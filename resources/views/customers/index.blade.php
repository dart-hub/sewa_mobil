@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Customer</h1>
        </div>

        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($customers as $customer)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $customer->phone_number }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini? Customer yang memiliki transaksi tidak dapat dihapus.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                    Tidak ada data customer.
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
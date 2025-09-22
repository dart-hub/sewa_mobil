@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Customer</h3>
                    <a href="{{ route('customers.index') }}" 
                       class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Kembali
                    </a>
                </div>
                
                <div class="border-t border-gray-200 pt-5">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nama</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->phone_number }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->updated_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
                
                @if($customer->transaksis->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobil</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Mobil</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($customer->transaksis as $transaksi)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->rent_date }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->mobil->car_name ?? 'Mobil ' . $transaksi->mobil_id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->number_of_cars }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($transaksi->total_cost, 2) }}</td>
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
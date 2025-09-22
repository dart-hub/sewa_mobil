@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Mobil</h3>
                    <a href="{{ route('mobils.index') }}" 
                       class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Kembali
                    </a>
                </div>
                
                <div class="border-t border-gray-200 pt-5">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nama Mobil</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mobil->car_name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tipe Mobil</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($mobil->car_type == 'reguler')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Reguler
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Premium
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Harga per Hari</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($mobil->price_per_day, 2) }}</dd>
                        </div>
                    </dl>
                </div>
                
                <div class="mt-6 flex items-center justify-end gap-x-3">
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('mobils.edit', $mobil) }}" 
                       class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <form action="{{ route('mobils.destroy', $mobil) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?')">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Tambah Stok')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Stok Baru</h3>
                    <a href="{{ route('stoks.index') }}" 
                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                
                <form action="{{ route('stoks.store') }}" method="POST" class="mt-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input 
                                type="date" 
                                id="date" 
                                name="date" 
                                value="{{ old('date', date('Y-m-d')) }}" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="mobil_id" class="block text-sm font-medium text-gray-700 mb-1">Mobil</label>
                            <select 
                                id="mobil_id" 
                                name="mobil_id" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                                <option value="">Pilih Mobil</option>
                                @foreach($mobils as $mobil)
                                    <option value="{{ $mobil->id }}" {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                                        {{ $mobil->car_name }} (Rp {{ number_format($mobil->price_per_day, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('mobil_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok</label>
                            <input 
                                type="number" 
                                id="stok" 
                                name="stok" 
                                min="0" 
                                value="{{ old('stok') }}" 
                                placeholder="Masukkan jumlah stok"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                            @error('stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-end gap-x-3">
                        <a href="{{ route('stoks.index') }}" 
                           class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Batal
                        </a>
                        <button 
                            type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <i class="fas fa-save mr-1"></i> Simpan Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

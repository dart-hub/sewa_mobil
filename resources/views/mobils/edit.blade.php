@extends('layouts.app')

@section('title', 'Edit Mobil')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Mobil</h3>
                    <a href="{{ route('mobils.index') }}" 
                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                
                <form action="{{ route('mobils.update', $mobil) }}" method="POST" class="mt-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="car_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Mobil</label>
                            <input 
                                type="text" 
                                id="car_name" 
                                name="car_name" 
                                value="{{ old('car_name', $mobil->car_name) }}" 
                                placeholder="Masukkan nama mobil"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                            @error('car_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="car_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Mobil</label>
                            <select 
                                id="car_type" 
                                name="car_type" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                                <option value="">Pilih tipe mobil</option>
                                <option value="reguler" {{ old('car_type', $mobil->car_type) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="premium" {{ old('car_type', $mobil->car_type) == 'premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                            @error('car_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-1">Harga per Hari (Rp)</label>
                            <input 
                                type="number" 
                                id="price_per_day" 
                                name="price_per_day" 
                                min="0" 
                                step="1000" 
                                value="{{ old('price_per_day', $mobil->price_per_day) }}" 
                                placeholder="Masukkan harga per hari"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                required
                            >
                            @error('price_per_day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-end gap-x-3">
                        <a href="{{ route('mobils.index') }}" 
                           class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Batal
                        </a>
                        <button 
                            type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

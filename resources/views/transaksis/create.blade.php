@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Transaksi Baru</h3>
                    <a href="{{ route('transaksis.index') }}" 
                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                
                <form action="{{ route('transaksis.store') }}" method="POST" class="mt-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                            <h4 class="text-md font-medium text-blue-800 mb-3">Informasi Customer</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                                    <input 
                                        type="text" 
                                        id="customer_name" 
                                        name="customer_name" 
                                        value="{{ old('customer_name') }}" 
                                        placeholder="Masukkan nama customer"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                    @error('customer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Customer</label>
                                    <input 
                                        type="text" 
                                        id="customer_phone" 
                                        name="customer_phone" 
                                        value="{{ old('customer_phone') }}" 
                                        placeholder="Masukkan nomor telepon"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                    @error('customer_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-md border border-green-200">
                            <h4 class="text-md font-medium text-green-800 mb-3">Informasi Mobil</h4>
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
                                        <option value="{{ $mobil->id }}" data-harga="{{ $mobil->price_per_day }}" data-stok="{{ $mobil->jumlahStokTerkini() }}" {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                                            {{ $mobil->car_name }} (Rp {{ number_format($mobil->price_per_day, 0, ',', '.') }}) - Stok: {{ $mobil->jumlahStokTerkini() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mobil_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mt-4">
                                <label for="number_of_cars" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Mobil</label>
                                <input 
                                    type="number" 
                                    id="number_of_cars" 
                                    name="number_of_cars" 
                                    min="1" 
                                    value="{{ old('number_of_cars', 1) }}" 
                                    placeholder="Masukkan jumlah mobil"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                    required
                                >
                                @error('number_of_cars')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200">
                            <h4 class="text-md font-medium text-yellow-800 mb-3">Tanggal Sewa</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="rent_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sewa</label>
                                    <input 
                                        type="date" 
                                        id="rent_date" 
                                        name="rent_date" 
                                        value="{{ old('rent_date') }}" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                    @error('rent_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                                    <input 
                                        type="date" 
                                        id="return_date" 
                                        name="return_date" 
                                        value="{{ old('return_date') }}" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                    @error('return_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-md border border-purple-200">
                            <h4 class="text-md font-medium text-purple-800 mb-3">Informasi Biaya</h4>
                            <div id="durasi_info" class="text-sm text-gray-600 mb-2">
                                Durasi akan dihitung otomatis setelah memilih tanggal sewa dan kembali
                            </div>
                            <div id="total_biaya_info" class="px-3 py-2 bg-green-100 text-green-800 rounded-md text-sm">
                                Total biaya akan dihitung otomatis
                            </div>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-md border border-indigo-200">
                            <h4 class="text-md font-medium text-indigo-800 mb-3">Informasi Pembayaran</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                                    <select 
                                        id="payment_status" 
                                        name="payment_status" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                        <option value="">Pilih Status Pembayaran</option>
                                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="lunas" {{ old('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    </select>
                                    @error('payment_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pembayaran</label>
                                    <select 
                                        id="payment_type" 
                                        name="payment_type" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2"
                                        required
                                    >
                                        <option value="">Pilih Tipe Pembayaran</option>
                                        <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                    </select>
                                    @error('payment_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-end gap-x-3">
                        <a href="{{ route('transaksis.index') }}" 
                           class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Batal
                        </a>
                        <button 
                            type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <i class="fas fa-save mr-1"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobilSelect = document.getElementById('mobil_id');
    const rentDateInput = document.getElementById('rent_date');
    const returnDateInput = document.getElementById('return_date');
    const numberOfCarsInput = document.getElementById('number_of_cars');
    const durasiInfo = document.getElementById('durasi_info');
    const totalBiayaInfo = document.getElementById('total_biaya_info');
    
    function hitungTotalBiaya() {
        const selectedOption = mobilSelect.options[mobilSelect.selectedIndex];
        const hargaPerHari = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const stokTersedia = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        
        const tanggalSewa = rentDateInput.value;
        const tanggalKembali = returnDateInput.value;
        const jumlahMobil = parseInt(numberOfCarsInput.value) || 0;
        
        if (!tanggalSewa || !tanggalKembali || hargaPerHari <= 0 || jumlahMobil <= 0) {
            durasiInfo.innerHTML = 'Durasi akan dihitung otomatis setelah memilih tanggal sewa dan kembali';
            totalBiayaInfo.innerHTML = 'Total biaya akan dihitung otomatis';
            return;
        }
        
        const sewa = new Date(tanggalSewa);
        const kembali = new Date(tanggalKembali);
        
        if (kembali < sewa) {
            durasiInfo.innerHTML = '<span class="text-red-600">Tanggal kembali harus setelah atau sama dengan tanggal sewa</span>';
            totalBiayaInfo.innerHTML = 'Total biaya akan dihitung otomatis';
            return;
        }
        
        // Hitung durasi dalam hari
        const diffTime = Math.abs(kembali - sewa);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 karena inklusif hari pertama
        
        durasiInfo.innerHTML = `Durasi: ${diffDays} hari (${tanggalSewa} sampai ${tanggalKembali})`;
        
        // Hitung total biaya
        const totalBiaya = diffDays * hargaPerHari * jumlahMobil;
        totalBiayaInfo.innerHTML = `Total Biaya: Rp ${totalBiaya.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})}`;
        
        // Periksa stok
        if (jumlahMobil > stokTersedia) {
            totalBiayaInfo.innerHTML += `<br><span class="text-red-600">Stok tidak mencukupi. Stok tersedia: ${stokTersedia}</span>`;
        }
    }
    
    mobilSelect.addEventListener('change', hitungTotalBiaya);
    rentDateInput.addEventListener('change', hitungTotalBiaya);
    returnDateInput.addEventListener('change', hitungTotalBiaya);
    numberOfCarsInput.addEventListener('input', hitungTotalBiaya);
    
    // Trigger perhitungan awal jika ada data lama
    if (mobilSelect.value && rentDateInput.value && returnDateInput.value) {
        hitungTotalBiaya();
    }
});
</script>
@endsection

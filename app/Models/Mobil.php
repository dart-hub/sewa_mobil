<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $fillable = [
        'car_name',
        'car_type',
        'price_per_day'
    ];
    
    /**
     * Relasi one-to-many dengan model Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
    
    /**
     * Relasi one-to-many dengan model Stok
     */
    public function stoks()
    {
        return $this->hasMany(Stok::class);
    }
    
    /**
     * Mendapatkan stok terkini untuk mobil ini
     */
    public function stokTerkini()
    {
        // Ambil entri stok terakhir berdasarkan tanggal
        return $this->stoks()->latest('date')->first();
    }
    
    /**
     * Mendapatkan jumlah stok terkini untuk mobil ini
     */
    public function jumlahStokTerkini()
    {
        $stok = $this->stokTerkini();
        return $stok ? $stok->stok : 0;
    }
}

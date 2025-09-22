<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'customer_id',
        'mobil_id',
        'rent_date',
        'return_date',
        'number_of_cars',
        'total_cost',
        'payment_status',
        'payment_type'
    ];
    
    /**
     * Relasi many-to-one dengan model Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    /**
     * Relasi many-to-one dengan model Mobil
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}

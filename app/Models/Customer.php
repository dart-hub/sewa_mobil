<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
    ];

    /**
     * Relasi one-to-many dengan model Transaksi
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
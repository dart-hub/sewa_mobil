<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $fillable = [
        'date',
        'mobil_id',
        'stok'
    ];
    
    /**
     * Relasi many-to-one dengan model Mobil
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}

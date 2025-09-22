<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi one-to-many dengan model Transaksi
     */
    // public function transaksis()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
    
    /**
     * Accessor untuk label role
     */
    public function getRoleLabelAttribute()
    {
        switch ($this->role) {
            case 'admin':
                return 'Administrator';
            case 'kasir':
                return 'Kasir';
            default:
                return ucfirst($this->role);
        }
    }
    
    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Cek apakah user adalah kasir
     */
    public function isKasir()
    {
        return $this->role === 'kasir';
    }
    
    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}

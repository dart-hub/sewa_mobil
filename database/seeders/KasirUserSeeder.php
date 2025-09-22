<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KasirUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user kasir default jika belum ada
        User::firstOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name' => 'Kasir',
                'role' => 'kasir',
                'password' => Hash::make('password'),
            ]
        );
    }
}

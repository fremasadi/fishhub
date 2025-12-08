<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dinas Perikanan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // === Peternak ===
        User::create([
            'name' => 'Budi Peternak',
            'email' => 'budi@benih.com',
            'password' => Hash::make('peternak123'),
            'role' => 'peternak',
        ]);

        User::create([
            'name' => 'Slamet Peternak',
            'email' => 'slamet@benih.com',
            'password' => Hash::make('peternak123'),
            'role' => 'peternak',
        ]);

        // === Pembudidaya ===
        User::create([
            'name' => 'Sari Pembudidaya',
            'email' => 'sari@budidaya.com',
            'password' => Hash::make('pembudidaya123'),
            'role' => 'pembudidaya',
        ]);

        User::create([
            'name' => 'Agus Pembudidaya',
            'email' => 'agus@budidaya.com',
            'password' => Hash::make('pembudidaya123'),
            'role' => 'pembudidaya',
        ]);
    }
}

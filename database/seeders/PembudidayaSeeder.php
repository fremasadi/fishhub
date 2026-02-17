<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Hash;

class PembudidayaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Sari Pembudidaya',  'email' => 'sari@budidaya.com',          'no_hp' => '081234567001', 'alamat' => 'Jl. Mawar No. 1, Kediri'],
            ['name' => 'Agus Pembudidaya',  'email' => 'agus@budidaya.com',          'no_hp' => '081234567002', 'alamat' => 'Jl. Melati No. 2, Kediri'],
            ['name' => 'Rina Pembudidaya',  'email' => 'rina@budidaya.com',          'no_hp' => '081234567003', 'alamat' => 'Jl. Kenanga No. 3, Kediri'],
            ['name' => 'Doni Pembudidaya',  'email' => 'doni@budidaya.com',          'no_hp' => '081234567004', 'alamat' => 'Jl. Dahlia No. 4, Kediri'],
            ['name' => 'Lina Pembudidaya',  'email' => 'lina@budidaya.com',          'no_hp' => '081234567005', 'alamat' => 'Jl. Anggrek No. 5, Kediri'],
        ];

        foreach ($data as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('password'),
                    'role' => 'pembudidaya',
                ]
            );

            Pembudidaya::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'no_hp' => $item['no_hp'],
                    'alamat' => $item['alamat'],
                ]
            );
        }

        echo "PembudidayaSeeder: 5 pembudidaya berhasil dibuat/diperbarui\n";
    }
}

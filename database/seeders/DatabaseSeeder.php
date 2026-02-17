<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Peternak;
use App\Models\Pembudidaya;
use App\Models\StokBenih;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $dummyImage = 'benih/ZZMU5RO4y2Bmeh4j44q8TX5iPi01yb2dDLocdYA5.png';

        $jenisBenih = [
            'Lele',
            'Nila Merah',
            'Nila Hitam',
            'Gurame',
            'Patin',
            'Bawal',
            'Koi',
            'Udang Vaname',
            'Bandeng',
            'Tombro'
        ];

        for ($i = 1; $i <= 10; $i++) {

            // =====================================================
            // 1. USER PETERNAR
            // =====================================================
            $user = User::create([
                'name' => "Peternak $i",
                'email' => "peternak$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'peternak',
            ]);

            // =====================================================
            // 2. DATA PETERNAK
            // =====================================================
            $peternak = Peternak::create([
                'user_id'   => $user->id,
                'alamat'    => "Alamat Peternak $i, Kediri",
                'no_hp'     => "08123" . rand(1000000, 9999999),
                'status_aktif' => 1,
                'latitude'  => -7.8 + rand(-100,100) / 1000,
                'longitude' => 112.0 + rand(-100,100) / 1000,
            ]);

            // =====================================================
            // 3. STOK BENIH (1 per peternak)
            // =====================================================
            StokBenih::create([
                'peternak_id' => $peternak->id,
                'jenis'        => $jenisBenih[$i-1],
                'jumlah'       => rand(500, 5000),
                'ukuran'       => '3–5 cm',
                'kualitas'     => 'Grade A',
                'harga'        => rand(100, 800),
                'status_stok'  => 'Tersedia',
                'status_validasi' => 'Terverifikasi',
                'tanggal_input' => now(),
                'image' => $dummyImage,
            ]);
        }

        // =====================================================
        // PEMBUDIDAYA
        // =====================================================
        for ($j = 1; $j <= 5; $j++) {
            $userBudidaya = User::create([
                'name' => "Pembudidaya $j",
                'email' => "pembudidaya$j@example.com",
                'password' => Hash::make('password'),
                'role' => 'pembudidaya',
            ]);

            Pembudidaya::create([
                'user_id' => $userBudidaya->id,
                'no_hp'   => "08567" . rand(1000000, 9999999),
                'alamat'  => "Alamat Pembudidaya $j, Kediri",
            ]);
        }

        echo "Seeder selesai: 10 peternak + 10 stok benih + 5 pembudidaya dibuat\n";

    }
}

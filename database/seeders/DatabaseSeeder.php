<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
// Akun Admin tetap (login admin) - pastikan tidak duplikat
        User::firstOrCreate(
            ['email' => 'royyan@mhs.unimal.ac.id'],
            [
                'name' => 'Royyan Ramadhan',
                'nim' => '240170179',
                'role' => 'admin',
                'password' => Hash::make('admin1234'),
                'email_verified_at' => now(),
            ]
        );

// 1. Seed jabatan & UKM terlebih dahulu
        // 2. Seed divisi per-UKM (butuh UKM sudah ada)
        // 3. Seed data dummy (30 anggota per UKM, data realistis)
        $this->call([
            JabatanSeeder::class,
            UkmSeeder::class,
            DivisiSeeder::class,
            DummyDataSeeder::class,
        ]);
    }
}

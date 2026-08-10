<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\Ukm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        // Setiap UKM memiliki divisi sendiri (bukan global).
        $defaultDivisis = [
            'Kesekretariatan',
            'Humas',
            'Publikasi & Dokumentasi',
            'Perlengkapan',
        ];

        $ukms = Ukm::orderBy('id')->get();

        if ($ukms->isEmpty()) {
            $this->command->error('Tidak ada UKM ditemukan. Jalankan UkmSeeder terlebih dahulu.');
            return;
        }

        foreach ($ukms as $ukm) {
            foreach ($defaultDivisis as $nama) {
                Divisi::firstOrCreate(
                    ['ukm_id' => $ukm->id, 'nama' => $nama],
                    ['status' => 'aktif']
                );
            }
        }
    }
}

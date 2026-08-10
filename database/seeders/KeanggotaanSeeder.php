<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Keanggotaan;
use App\Models\Kepengurusan;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeanggotaanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $ukms = Ukm::all();

        if ($users->isEmpty() || $ukms->isEmpty()) {
            return;
        }

        // Assign each user as a member of at least one UKM (non-structural)
        foreach ($users as $index => $user) {
            $ukm = $ukms->get($index % $ukms->count());

            // Check if they're already in kepengurusan for this UKM
            $existingKepengurusan = Kepengurusan::where('user_id', $user->id)
                ->where('ukm_id', $ukm->id)
                ->exists();

            if (!$existingKepengurusan) {
                $keanggotaan = Keanggotaan::create([
                    'user_id' => $user->id,
                    'ukm_id' => $ukm->id,
                    'tanggal_daftar' => now()->subMonths(rand(1, 12)),
                    'status' => 'diterima',
                    'no_hp' => '08' . rand(100000000, 999999999),
                    'fakultas' => 'Teknik',
                    'program_studi' => 'Teknik Informatika',
                    'angkatan' => '2024',
                    'alasan' => 'Tertarik mengembangkan minat dan bakat di UKM ini.',
                ]);

                // Konsisten dengan alur approve(): setelah diterima, otomatis
                // menjadi anggota (record kepengurusan dengan jabatan Anggota).
                $jabatanAnggota = Jabatan::where('nama', 'Anggota')->first();
                if ($jabatanAnggota) {
                    Kepengurusan::create([
                        'ukm_id' => $ukm->id,
                        'user_id' => $user->id,
                        'jabatan_id' => $jabatanAnggota->id,
                        'tanggal_mulai' => now()->subMonths(rand(1, 12)),
                        'status' => 'aktif',
                    ]);
                }
            }
        }
    }
}

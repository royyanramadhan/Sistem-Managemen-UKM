<?php

namespace Database\Seeders;

use App\Models\Kepengurusan;
use App\Models\Ukm;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KepengurusanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(10)->get();
        $ukms = Ukm::all();
        $jabatans = Jabatan::all();

        if ($users->count() > 0 && $ukms->count() > 0 && $jabatans->count() > 0) {
            $idx = 0;
            foreach ($ukms as $ukm) {
                // Tambah Ketua Umum
                if ($idx < $users->count()) {
                    Kepengurusan::create([
                        'ukm_id' => $ukm->id,
                        'user_id' => $users[$idx]->id,
                        'jabatan_id' => $jabatans->firstWhere('nama', 'Ketua Umum')->id,
                        'tanggal_mulai' => now()->subMonths(6),
                        'status' => 'aktif',
                    ]);
                    $idx++;
                }

                // Tambah Sekretaris Umum
                if ($idx < $users->count()) {
                    Kepengurusan::create([
                        'ukm_id' => $ukm->id,
                        'user_id' => $users[$idx]->id,
                        'jabatan_id' => $jabatans->firstWhere('nama', 'Sekretaris Umum')->id,
                        'tanggal_mulai' => now()->subMonths(5),
                        'status' => 'aktif',
                    ]);
                    $idx++;
                }

                // Tambah Bendahara
                if ($idx < $users->count()) {
                    Kepengurusan::create([
                        'ukm_id' => $ukm->id,
                        'user_id' => $users[$idx]->id,
                        'jabatan_id' => $jabatans->firstWhere('nama', 'Bendahara')->id,
                        'tanggal_mulai' => now()->subMonths(4),
                        'status' => 'aktif',
                    ]);
                    $idx++;
                }
            }
        }
    }
}

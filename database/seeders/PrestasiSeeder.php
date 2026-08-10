<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $ukms = Ukm::all();
        $users = User::limit(10)->get();

        $prestasiData = [
            [
                'nama_prestasi' => 'Juara 1 Lomba Karya Ilmiah Nasional',
                'tingkat' => 'nasional',
                'deskripsi' => 'Meraih juara pertama dalam kompetisi karya ilmiah tingkat nasional',
            ],
            [
                'nama_prestasi' => 'Juara 2 Turnamen Basket Regional',
                'tingkat' => 'regional',
                'deskripsi' => 'Meraih juara kedua dalam turnamen basket antar universitas se-regional',
            ],
            [
                'nama_prestasi' => 'Best Project Pameran Bisnis',
                'tingkat' => 'lokal',
                'deskripsi' => 'Mendapat penghargaan sebagai project terbaik dalam pameran bisnis kampus',
            ],
            [
                'nama_prestasi' => 'Finalis Lomba Fotografi Internasional',
                'tingkat' => 'internasional',
                'deskripsi' => 'Menjadi finalis dalam kompetisi fotografi tingkat internasional',
            ],
            [
                'nama_prestasi' => 'Juara 3 Lomba Debat Bahasa Inggris',
                'tingkat' => 'nasional',
                'deskripsi' => 'Meraih juara ketiga dalam lomba debat bahasa Inggris tingkat nasional',
            ],
        ];

        foreach ($ukms as $index => $ukm) {
            $data = $prestasiData[$index % count($prestasiData)];

            Prestasi::create([
                'ukm_id' => $ukm->id,
                'user_id' => $users->get($index % $users->count())->id ?? null,
                'nama_prestasi' => $data['nama_prestasi'] . ' (' . $ukm->nama . ')',
                'tingkat' => $data['tingkat'],
                'tanggal' => now()->subMonths(rand(1, 6)),
                'deskripsi' => $data['deskripsi'],
            ]);
        }
    }
}


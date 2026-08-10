<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Ukm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $ukms = Ukm::all();
        
        $beritaList = [
            'Penerimaan Anggota Baru Telah Dibuka!',
            'Sukses Menyelenggarakan Kegiatan Bakti Sosial',
            'Meraih Juara 1 Tingkat Nasional',
            'Pelatihan Kepemimpinan Sukses Dilaksanakan',
            'Persiapan Lomba Mendatang',
        ];

        foreach ($ukms as $ukm) {
            foreach ($beritaList as $judul) {
                $fullJudul = $judul . ' - ' . $ukm->nama;
                Berita::create([
                    'ukm_id' => $ukm->id,
                    'judul' => $fullJudul,
                    'slug' => Str::slug($fullJudul) . '-' . rand(100, 999),
                    'isi' => 'Ini adalah isi berita contoh untuk kegiatan dan prestasi yang diraih oleh ' . $ukm->nama . '. Berita ini hanya untuk keperluan dummy data.',
                    'kategori' => 'Kegiatan',
                    'tanggal_publikasi' => now()->subDays(rand(1, 30)),
                    'status' => 'published',
                    'tampil_di_dashboard' => true,
                ]);
            }
        }
    }
}

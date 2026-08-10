<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Ukm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $ukms = Ukm::all();

        $kegiatanData = [
            [
                'nama' => 'Rapat Koordinasi Awal Tahun',
                'deskripsi' => 'Rapat koordinasi awal tahun untuk menyusun program kerja',
                'tempat' => 'Ruang Aula Kampus',
                'jenis' => 'rapat',
                'status' => 'selesai',
            ],
            [
                'nama' => 'Pelatihan Kepemimpinan',
                'deskripsi' => 'Pelatihan pengembangan softskill kepemimpinan anggota',
                'tempat' => 'Gedung Serbaguna',
                'jenis' => 'pelatihan',
                'status' => 'direncanakan',
            ],
            [
                'nama' => 'Lomba Karya Tulis Ilmiah',
                'deskripsi' => 'Kompetisi penulisan karya ilmiah antar mahasiswa',
                'tempat' => 'Aula Universitas',
                'jenis' => 'lomba',
                'status' => 'berlangsung',
            ],
            [
                'nama' => 'Bakti Sosial',
                'deskripsi' => 'Kegiatan bakti sosial ke panti asuhan',
                'tempat' => 'Panti Asuhan Harapan',
                'jenis' => 'kegiatan',
                'status' => 'direncanakan',
            ],
            [
                'nama' => 'Seminar Kewirausahaan',
                'deskripsi' => 'Seminar tentang kewirausahaan untuk mahasiswa',
                'tempat' => 'Ruang Seminar Lt. 3',
                'jenis' => 'kegiatan',
                'status' => 'selesai',
            ],
        ];

        foreach ($ukms as $index => $ukm) {
            foreach ($kegiatanData as $data) {
                Kegiatan::create([
                    'ukm_id' => $ukm->id,
                    'nama' => $data['nama'] . ' - ' . $ukm->nama,
                    'deskripsi' => $data['deskripsi'],
                    'tanggal_mulai' => now()->addDays(rand(-30, 60)),
                    'tanggal_selesai' => now()->addDays(rand(1, 90)),
                    'tempat' => $data['tempat'],
                    'jenis' => $data['jenis'],
                    'status' => $data['status'],
                ]);
            }
        }
    }
}


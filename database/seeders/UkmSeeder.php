<?php

namespace Database\Seeders;

use App\Models\Ukm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UkmSeeder extends Seeder
{
    public function run(): void
    {
        $ukms = [
            [
                'nama' => 'Himpunan Mahasiswa Teknik',
                'deskripsi' => 'Organisasi mahasiswa program studi teknik',
                'bidang' => 'Akademik',
                'email' => 'hmteknik@university.ac.id',
                'telepon' => '081234567890',
                'alamat' => 'Gedung Teknik, Lantai 2',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Klub Olahraga Basket',
                'deskripsi' => 'Organisasi olahraga basket mahasiswa',
                'bidang' => 'Olahraga',
                'email' => 'basket@university.ac.id',
                'telepon' => '081234567891',
                'alamat' => 'Lapangan Basket Kampus',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Himpunan Mahasiswa Bisnis',
                'deskripsi' => 'Organisasi mahasiswa program studi bisnis',
                'bidang' => 'Akademik',
                'email' => 'hmbisnis@university.ac.id',
                'telepon' => '081234567892',
                'alamat' => 'Gedung Bisnis, Lantai 3',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Komunitas Seni dan Budaya',
                'deskripsi' => 'Organisasi pengembangan seni dan budaya',
                'bidang' => 'Seni',
                'email' => 'senibudaya@university.ac.id',
                'telepon' => '081234567893',
                'alamat' => 'Aula Kampus',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Unit Kegiatan Mahasiswa Fotografi',
                'deskripsi' => 'Komunitas pecinta fotografi',
                'bidang' => 'Hobi',
                'email' => 'fotografi@university.ac.id',
                'telepon' => '081234567894',
                'alamat' => 'Studio Fotografi',
                'status' => 'aktif',
            ],
        ];

        foreach ($ukms as $ukm) {
            Ukm::create($ukm);
        }
    }
}

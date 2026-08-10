<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $jabatans = [
            [
                'nama' => 'Ketua Umum',
                'deskripsi' => 'Pemimpin utama organisasi',
                'level' => 1,
            ],
            [
                'nama' => 'Wakil Ketua',
                'deskripsi' => 'Pendamping ketua umum',
                'level' => 2,
            ],
            [
                'nama' => 'Sekretaris Umum',
                'deskripsi' => 'Mengelola administrasi umum',
                'level' => 2,
            ],
            [
                'nama' => 'Bendahara',
                'deskripsi' => 'Mengelola keuangan organisasi',
                'level' => 2,
            ],
            [
                'nama' => 'Kepala Divisi',
                'deskripsi' => 'Pemimpin divisi',
                'level' => 3,
            ],
            [
                'nama' => 'Sekretaris Divisi',
                'deskripsi' => 'Administrasi divisi',
                'level' => 4,
            ],
            [
                'nama' => 'Anggota',
                'deskripsi' => 'Anggota umum organisasi',
                'level' => 5,
            ],
        ];

        foreach ($jabatans as $jabatan) {
            Jabatan::create($jabatan);
        }
    }
}

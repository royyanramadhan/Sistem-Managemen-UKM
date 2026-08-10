<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Keanggotaan;
use App\Models\Kepengurusan;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Daftar nama depan (first name) mahasiswa Indonesia.
     */
    protected array $firstNamesMale = [
        'Ahmad', 'Muhammad', 'Dimas', 'Fajar', 'Bagas', 'Rizky', 'Yoga', 'Rian',
        'Aldi', 'Wahyu', 'Andi', 'Budi', 'Deni', 'Eko', 'Fikri', 'Gilang',
        'Hendra', 'Iqbal', 'Joko', 'Kevin', 'Lukman', 'Maulana', 'Nanda', 'Oki',
        'Panji', 'Qomar', 'Rahmat', 'Sandy', 'Taufik', 'Umar', 'Vicky', 'Wawan',
        'Xavier', 'Yudha', 'Zaki', 'Aditya', 'Bayu', 'Candra', 'Dedi', 'Endra',
        'Fauzi', 'Genta', 'Hafiz', 'Ilham', 'Jefri', 'Kurniawan', 'Lutfi', 'Naufal',
        'Oscar', 'Pandu', 'Rendi', 'Satria', 'Teguh', 'Ucok', 'Vino', 'Willy',
        'Yanuar', 'Agus', 'Bonar', 'Dodi', 'Erwin', 'Fadhil', 'Galuh', 'Hasan',
        'Ismail', 'Julian', 'Kamil', 'Leo', 'Miko', 'Noval', 'Okta', 'Prima',
        'Raka', 'Surya', 'Tomi', 'Utomo', 'Vito', 'Wibowo', 'Yusuf', 'Anang',
    ];

    protected array $firstNamesFemale = [
        'Nabila', 'Putri', 'Siti', 'Nurul', 'Rina', 'Dewi', 'Intan', 'Riska',
        'Aisyah', 'Amelia', 'Bella', 'Citra', 'Dinda', 'Elvira', 'Fitri', 'Gita',
        'Hana', 'Indah', 'Jihan', 'Kirana', 'Lestari', 'Maya', 'Nadia', 'Oktavia',
        'Puspita', 'Rahma', 'Salsabila', 'Tiara', 'Ulfah', 'Vina', 'Winda', 'Yulia',
        'Zahra', 'Aulia', 'Bunga', 'Cantika', 'Dian', 'Eka', 'Fadhilah', 'Gadis',
        'Hesti', 'Ira', 'Jasmine', 'Kartika', 'Laila', 'Melati', 'Nisa', 'Olivia',
        'Puti', 'Ratna', 'Sari', 'Tania', 'Umi', 'Vera', 'Wulan', 'Yuli',
        'Alya', 'Bella', 'Chika', 'Dara', 'Elisa', 'Fina', 'Gresia', 'Halimah',
        'Indri', 'Jesslyn', 'Kezia', 'Lia', 'Mutiara', 'Ningsih', 'Oktaviani', 'Pramesti',
        'Rini', 'Silvia', 'Tasya', 'Utami', 'Vania', 'Wulandari', 'Anisa', 'Citra',
    ];

    /**
     * Daftar nama belakang (last name) Indonesia.
     */
    protected array $lastNames = [
        'Fauzan', 'Rizki', 'Pratama', 'Ramadhan', 'Prakoso', 'Maulana', 'Prasetyo',
        'Firmansyah', 'Saputra', 'Hidayat', 'Ayuningtyas', 'Aisyah', 'Hidayah',
        'Oktaviani', 'Lestari', 'Permata', 'Amelia', 'Santoso', 'Wijaya', 'Kurniawan',
        'Setiawan', 'Nugroho', 'Haryanto', 'Susanto', 'Putra', 'Utama', 'Permana',
        'Rahayu', 'Sari', 'Wati', 'Anggraini', 'Puspita', 'Safitri', 'Larasati',
        'Maharani', 'Kusuma', 'Hartono', 'Gunawan', 'Halim', 'Siregar', 'Nasution',
        'Simbolon', 'Saragih', 'Tamba', 'Sinaga', 'Manurung', 'Sihombing', 'Siagian',
        'Lubis', 'Harahap', 'Ritonga', 'Situmorang', 'Pardede', 'Hutapea', 'Pohan',
        'Ginting', 'Sembiring', 'Tarigan', 'Karokaro', 'Peranginangin', 'Sitepu',
        'Yusuf', 'Ramadhan', 'Fadhillah', 'Zul', 'Rahman', 'Ananda', 'Pradana',
        'Wibisono', 'Sudirman', 'Hakim', 'Mubarok', 'Alamsyah', 'Firdaus', 'Akbar',
    ];

    /**
     * Peta fakultas -> program studi yang valid.
     */
    protected array $fakultasProdi = [
        'Teknik' => [
            'Teknik Informatika', 'Sistem Informasi', 'Teknik Sipil', 'Teknik Industri',
            'Teknik Elektro', 'Teknik Mesin',
        ],
        'Ekonomi dan Bisnis' => [
            'Manajemen', 'Akuntansi', 'Ekonomi Pembangunan',
        ],
        'FKIP' => [
            'Pendidikan Matematika', 'Pendidikan Bahasa Indonesia',
            'Pendidikan Bahasa Inggris', 'Pendidikan Biologi',
        ],
        'FISIP' => [
            'Ilmu Komunikasi', 'Ilmu Administrasi Negara', 'Sosiologi',
        ],
        'Pertanian' => [
            'Agroteknologi', 'Agribisnis',
        ],
        'Perikanan' => [
            'Budidaya Perairan', 'Teknologi Hasil Perikanan',
        ],
        'Hukum' => [
            'Ilmu Hukum',
        ],
        'Kedokteran' => [
            'Pendidikan Dokter',
        ],
    ];

    /**
     * Fakultas yang diprioritaskan untuk distribusi (agar beragam).
     */
    protected array $preferredFakultas = [
        'Teknik', 'Ekonomi dan Bisnis', 'FKIP', 'FISIP', 'Pertanian', 'Perikanan', 'Hukum', 'Kedokteran',
    ];

    /**
     * Alasan / motivasi realistis saat mendaftar UKM.
     */
    protected array $alasan = [
        'Ingin mengembangkan minat dan bakat di bidang ini.',
        'Tertarik untuk aktif berorganisasi di kampus.',
        'Ingin memperluas relasi dan pengalaman berorganisasi.',
        'Mendukung kegiatan kemahasiswaan dan pengembangan diri.',
        'Ingin berkontribusi untuk kemajuan organisasi.',
        'Ingin belajar bekerja sama dalam tim yang solid.',
        'Tertarik dengan program kerja yang dijalankan UKM ini.',
        'Ingin mengisi waktu luang dengan kegiatan yang bermanfaat.',
    ];

    public function run(): void
    {
        $ukms = Ukm::orderBy('id')->get();
        $jabatanKetua = Jabatan::where('nama', 'Ketua Umum')->first();
        $jabatanWakil = Jabatan::where('nama', 'Wakil Ketua')->first();
        $jabatanSekretaris = Jabatan::where('nama', 'Sekretaris Umum')->first();
        $jabatanBendahara = Jabatan::where('nama', 'Bendahara')->first();
        $jabatanKepalaDivisi = Jabatan::where('nama', 'Kepala Divisi')->first();
        $jabatanSekretarisDivisi = Jabatan::where('nama', 'Sekretaris Divisi')->first();
        $jabatanAnggota = Jabatan::where('nama', 'Anggota')->first();

        if ($ukms->isEmpty()) {
            $this->command->error('Tidak ada UKM ditemukan. Jalankan UkmSeeder terlebih dahulu.');
            return;
        }

        $nimCounter = 240170001;
        $phoneCounter = 0;

        foreach ($ukms as $ukm) {
            // Divisi milik UKM ini saja (bukan global)
            $divisis = $ukm->divisis()->orderBy('id')->get();
            if ($divisis->isEmpty()) {
                $this->command->error("UKM '{$ukm->nama}' tidak memiliki divisi. Jalankan DivisiSeeder terlebih dahulu.");
                continue;
            }

            // Struktur per UKM: 1 Ketua, 1 Wakil, 1 Sekretaris, 1 Bendahara,
            // 4 Kepala Divisi, 4 Sekretaris Divisi, sisanya Anggota = 30.
            $rolesInOrder = [
                $jabatanKetua,
                $jabatanWakil,
                $jabatanSekretaris,
                $jabatanBendahara,
            ];
            foreach ($divisis->take(4) as $divisi) {
                $rolesInOrder[] = $jabatanKepalaDivisi;
                $rolesInOrder[] = $jabatanSekretarisDivisi;
            }
            while (count($rolesInOrder) < 30) {
                $rolesInOrder[] = $jabatanAnggota;
            }

$kadivDivisis = $divisis->take(4)->values();
            $kadivCounter = 0;    // rotasi divisi untuk Kepala Divisi
            $sekdivCounter = 0;   // rotasi divisi untuk Sekretaris Divisi

            foreach ($rolesInOrder as $jabatan) {
                [$name, $gender] = $this->generateName();
                $nim = (string) $nimCounter++;
                $email = strtolower(str_replace(' ', '', $name)) . '_' . $nim . '@gmail.com';

                $fakultas = $this->randomFakultas();
                $prodi = $this->randomProdi($fakultas);
                $angkatan = (string) $this->randomAngkatan();

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'nim' => $nim,
                    'role' => 'user',
                    'password' => Hash::make('12345678'),
                    'email_verified_at' => now(),
                    'fakultas' => $fakultas,
                    'program_studi' => $prodi,
                    'angkatan' => $angkatan,
                    'telepon' => $this->generatePhone($phoneCounter++),
                ]);

                $tanggalDaftar = now()->subMonths(rand(1, 18))->subDays(rand(0, 20));

                Keanggotaan::create([
                    'user_id' => $user->id,
                    'ukm_id' => $ukm->id,
                    'tanggal_daftar' => $tanggalDaftar,
                    'status' => 'diterima',
                    'no_hp' => $user->telepon,
                    'fakultas' => $fakultas,
                    'program_studi' => $prodi,
                    'angkatan' => $angkatan,
                    'alasan' => $this->alasan[array_rand($this->alasan)],
                ]);

                // Tentukan divisi:
                // - Kepala Divisi / Sekretaris Divisi → rotasi di 4 divisi pertama
                // - Anggota → divisi acak merata
                // - Ketua/Wakil/Sekretaris/Bendahara → tanpa divisi (null)
$divisiId = null;
                if ($jabatan->id === $jabatanKepalaDivisi->id) {
                    $divisiId = $kadivDivisis->get($kadivCounter % $kadivDivisis->count())->id;
                    $kadivCounter++;
                } elseif ($jabatan->id === $jabatanSekretarisDivisi->id) {
                    $divisiId = $kadivDivisis->get($sekdivCounter % $kadivDivisis->count())->id;
                    $sekdivCounter++;
                } elseif ($jabatan->id === $jabatanAnggota->id) {
                    $divisiId = $divisis->get($this->randomDivisiIndex($ukm->id, $user->id, $divisis->count()))->id;
                }

                Kepengurusan::create([
                    'ukm_id' => $ukm->id,
                    'user_id' => $user->id,
                    'jabatan_id' => $jabatan->id,
                    'divisi_id' => $divisiId,
                    'tanggal_mulai' => $tanggalDaftar->copy()->addDays(rand(3, 10)),
                    'status' => 'aktif',
                ]);
            }

            $this->command->info("UKM '{$ukm->nama}' berhasil diisi 30 anggota.");
        }

        $this->command->info('DummyDataSeeder selesai. Total user: ' . ($nimCounter - 240170001));
    }

    /**
     * Generate nama Indonesia (dengan gender).
     */
    protected function generateName(): array
    {
        $gender = rand(0, 1); // 0 = laki-laki, 1 = perempuan
        if ($gender === 0) {
            $first = $this->firstNamesMale[array_rand($this->firstNamesMale)];
        } else {
            $first = $this->firstNamesFemale[array_rand($this->firstNamesFemale)];
        }
        $last = $this->lastNames[array_rand($this->lastNames)];

        // Kadang tambahkan nama tengah agar lebih natural
        if (rand(0, 1) === 1) {
            $middlePool = $gender === 0 ? $this->firstNamesMale : $this->firstNamesFemale;
            $middle = $middlePool[array_rand($middlePool)];
            return [$first . ' ' . $middle . ' ' . $last, $gender];
        }

        return [$first . ' ' . $last, $gender];
    }

    /**
     * Pilih fakultas secara merata dari daftar preferensi.
     */
    protected function randomFakultas(): string
    {
        return $this->preferredFakultas[array_rand($this->preferredFakultas)];
    }

    /**
     * Pilih prodi yang valid untuk fakultas tertentu.
     */
    protected function randomProdi(string $fakultas): string
    {
        $prodis = $this->fakultasProdi[$fakultas];
        return $prodis[array_rand($prodis)];
    }

    /**
     * Generate angkatan secara acak.
     */
    protected function randomAngkatan(): int
    {
        $angkatans = [2021, 2022, 2023, 2024];
        return $angkatans[array_rand($angkatans)];
    }

    /**
     * Pilih indeks divisi secara deterministik-per-UkM&user agar distribusi merata.
     */
    protected function randomDivisiIndex(int $ukmId, int $userId, int $count): int
    {
        return abs(crc32($ukmId . '-' . $userId)) % $count;
    }

    /**
     * Generate nomor HP Indonesia yang realistis dan unik.
     * Memastikan selalu 12 digit (08xxxxxxxxxx).
     */
    protected function generatePhone(int $counter): string
    {
        // Prefix 8 digit + 4 digit berurutan => total 12 digit (08xxxxxxxxxx)
        $suffix = 1000 + $counter; // 1000, 1001, ...
        return '08123456' . (string) $suffix;
    }
}

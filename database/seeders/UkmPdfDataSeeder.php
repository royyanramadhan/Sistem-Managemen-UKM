<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ukm;
use App\Models\Prestasi;
use App\Models\Kegiatan;
use App\Models\User;

class UkmPdfDataSeeder extends Seeder
{
    public function run()
    {
        $ukmData = [
            // 1. UKM-KSM Creative Minority
            [
                'match_name' => '%Creative Minority%',
                'profil' => [
                    'deskripsi' => 'UKM-KSM Creative Minority merupakan salah satu unit kegiatan mahasiswa di Universitas Malikussaleh yang berfokus pada pengembangan daya pikir kritis, pembentukan gagasan kreatif, serta bergerak aktif di bidang pengabdian masyarakat dan penulisan ilmiah. Organisasi ini didirikan pertama kali pada tahun 2009 dan sempat aktif kembali setelah vakum pada tahun 2013.',
                    'bidang' => 'Kepenulisan (Karya Tulis Ilmiah, cerpen, puisi), Riset/Penelitian, Pengabdian Masyarakat, Pengembangan Sumber Daya Manusia (HRD), Public Relation, Debat, dan Teknologi.',
                ],
                'prestasi' => [
                    [
                        'nama_prestasi' => 'Peringkat Silver pada International Education Competition (IEC) 2024',
                        'tingkat' => 'internasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Cut Fatimah Zahra yang merupakan anggota aktif struktur divisi Karya Tulis UKM-KSM Creative Minority berhasil membawa nama Unimal di kancah internasional. Ia bersama tim lintas disiplinnya sukses mengamankan peringkat silver setelah bersaing dalam kompetisi inovasi pendidikan tersebut. Penyelenggara: University of Malaya, Malaysia. Hasil: Peringkat Silver (Medali Silver). Penerima: Cut Fatimah Zahra (Anggota Divisi Karya Tulis Creative Minority) bersama timnya (Rahmatul Ulya, Azlina Rahmadani, Nurhasanah, Ratih Monalisa, dan Hafnida). Sumber: UnimalNews',
                        'penerima_raw' => 'Cut Fatimah Zahra',
                    ],
                    [
                        'nama_prestasi' => 'Juara 2 Lomba Essay Internasional CREATION 1.0',
                        'tingkat' => 'internasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Mahasiswi Fakultas Hukum Universitas Malikussaleh ini berhasil meraih penghargaan internasional dalam ajang perdana yang diadakan oleh Creative Minority. Mereka menuangkan gagasan solutif dalam bentuk esai internasional yang dipresentasikan di depan dewan juri. Penyelenggara: UKM-KSM Creative Minority Universitas Malikussaleh. Hasil: Juara 2. Penerima: Fitrida Rezeki Trifani dan Shafa Amira Putri Lubis. Sumber: Kompasiana',
                        'penerima_raw' => 'Fitrida Rezeki Trifani',
                    ],
                    [
                        'nama_prestasi' => 'Juara 3 Lomba Cerpen Tingkat Nasional 2024',
                        'tingkat' => 'nasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Perwakilan mahasiswa Universitas Malikussaleh berhasil mengamankan posisi tiga besar dalam ajang menulis kreatif berskala nasional. Kompetisi ini diikuti oleh berbagai peserta dari institusi sekolah dan perguruan tinggi di seluruh Indonesia. Penyelenggara: UKM-KSM Creative Minority Universitas Malikussaleh. Hasil: Juara 3. Penerima: Ramazani Akbar. Sumber: UnimalNews',
                        'penerima_raw' => 'Ramazani Akbar',
                    ]
                ],
                'kegiatan' => [
                    [
                        'nama' => 'Creative Research National and International Competition (CREATION) 1.0 & 2.0',
                        'deskripsi' => 'CREATION merupakan agenda kompetisi akbar tahunan yang diinisiasi oleh Creative Minority. Kategori nasional memperlombakan Debat, Policy Brief, Essay Nasional, dan Business Plan, sementara kategori internasional menggelar perlombaan daring seperti Photography, Essay International, Poster, dan News Anchor. Tujuan: Menjadi wadah bagi mahasiswa nasional maupun internasional untuk mengasah keterampilan berpikir kritis, menulis ilmiah, serta memperluas jejaring prestasi. Sumber: Website Resmi Universitas Malikussaleh & Instagram @bemunimal',
                        'tanggal_mulai' => '2024-09-20',
                        'tanggal_selesai' => '2025-09-30',
                        'tempat' => 'Aula Cut Meutia, Kampus Bukit Indah, Lhokseumawe (Untuk cabang luring/nasional).',
                        'jenis' => 'lomba',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Pelatihan Analisis Data "SPSS Insight Class 2026"',
                        'deskripsi' => 'Kegiatan pelatihan yang diselenggarakan untuk memberikan bekal teknis kepada mahasiswa mengenai metodologi penelitian kuantitatif. Fokus pelatihan ini menitikberatkan pada pengoperasian perangkat lunak SPSS untuk mengolah data riset. Tujuan: Membekali mahasiswa dengan keterampilan analisis data kuantitatif guna menyokong kebutuhan tugas akhir, skripsi, maupun riset ilmiah lainnya. Sumber: UnimalNews',
                        'tanggal_mulai' => '2026-07-01',
                        'tanggal_selesai' => '2026-07-31',
                        'tempat' => 'Universitas Malikussaleh, Lhokseumawe.',
                        'jenis' => 'pelatihan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Pengabdian Masyarakat "CM Mengajar" di Panti Asuhan',
                        'deskripsi' => 'Pengurus Creative Minority terjun langsung ke panti asuhan untuk memberikan kelas pelatihan interaktif kepada anak-anak panti. Kelas yang dibuka meliputi pelatihan penulisan puisi, teknik berbicara di depan umum (public speaking), seni kriya, hingga permainan edukatif Rangking Satu. Tujuan: Membantu meningkatkan motivasi belajar anak-anak panti asuhan dan mengasah kreativitas serta kepercayaan diri mereka melalui materi terapan. Sumber: UnimalNews',
                        'tanggal_mulai' => '2022-11-05',
                        'tanggal_selesai' => '2022-11-05',
                        'tempat' => 'Panti Asuhan YPI Miftahul Jannah, Krueng Geukueh, Kecamatan Dewantara, Aceh Utara.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ]
                ]
            ],

            // 2. UKM Seni dan Budaya Meurah Silue
            [
                'match_name' => '%Meurah Silue%',
                'profil' => [
                    'deskripsi' => 'UKM Seni dan Budaya Meurah Silue merupakan organisasi kemahasiswaan di Universitas Malikussaleh yang menjadi wadah bagi mahasiswa untuk menyalurkan minat, bakat, dan kreativitas di bidang kesenian. Organisasi ini aktif berkarya sekaligus berupaya melestarikan nilai-nilai kebudayaan lokal tradisional Aceh hingga nasional.',
                    'bidang' => 'Pengembangan seni tari tradisional, musik etnik, teater/seni pertunjukan, olah vokal, lagu daerah, sastra, dan seni rupa.',
                ],
                'prestasi' => [
                    [
                        'nama_prestasi' => 'Juara 2 Kategori Tari Tradisional pada Universitas Syiah Kuala (USK) Fair XV',
                        'tingkat' => 'regional',
                        'tanggal' => '2021-01-01',
                        'deskripsi' => 'Tim tari dari UKM Meurah Silue Unimal sukses menorehkan prestasi membanggakan setelah membawakan tarian tradisional bertajuk "Alon Buluek". Penghargaan ini diraih berkat latihan intensif dan dedikasi tinggi para anggota di tengah berbagai keterbatasan fasilitas latihan. Kompetisi: Universitas Syiah Kuala Fair XV 2021. Hasil: Juara 2. Penerima: Tim Penari UKM Seni Budaya Meurah Silue Universitas Malikussaleh. Sumber: UnimalNews',
                        'penerima_raw' => 'Tim Penari UKM Seni Budaya Meurah Silue',
                    ],
                    [
                        'nama_prestasi' => 'Juara 1 Kategori Seni Musik dan Vokal (Lagu Daerah) pada Panggung Seni Etnografis Dies Natalis Unimal',
                        'tingkat' => 'lokal',
                        'tanggal' => '2022-01-01',
                        'deskripsi' => 'Tim delegasi musik dari UKM Seni Meurah Silue berhasil memukau dewan juri dan mengamankan podium pertama pada kategori aransemen serta penampilan Lagu Daerah. Kompetisi internal ini diselenggarakan sebagai rangkaian perayaan hari jadi universitas guna menumbuhkan kecintaan terhadap seni lokal. Kompetisi: Lomba Panggung Seni Etnografis Dies Natalis Universitas Malikussaleh. Hasil: Juara 1. Penerima: Tim Musik/Vokal UKM Seni Meurah Silue. Sumber: UnimalNews',
                        'penerima_raw' => 'Tim Musik/Vokal UKM Seni Meurah Silue',
                    ],
                    [
                        'nama_prestasi' => 'Perwakilan Provinsi Aceh pada Parade Teater Daerah Ke-8 Tingkat Nasional',
                        'tingkat' => 'nasional',
                        'tanggal' => '2019-01-01',
                        'deskripsi' => 'Salah satu kader terbaik UKM Seni Budaya Meurah Silue berhasil lolos seleksi untuk mewakili nama Provinsi Aceh di panggung nasional. Dalam ajang ini, mereka membawakan pertunjukan teater berkonsep komedi yang dikombinasikan dengan tradisi lokal Aceh. Penyelenggara: Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi. Hasil: Terpilih sebagai Perwakilan Provinsi Aceh. Penerima: Zafian (Anggota/Delegasi UKM Seni Budaya Meurah Silue). Sumber: UnimalNews',
                        'penerima_raw' => 'Zafian',
                    ]
                ],
                'kegiatan' => [
                    [
                        'nama' => 'Kegiatan Edukasi Kebudayaan "Saweu Seni" di Sekolah Menengah Lhokseumawe',
                        'deskripsi' => 'UKM Seni Budaya Meurah Silue menggelar program pengabdian ke sekolah-sekolah untuk memperkenalkan dan melestarikan alat musik serta tarian tradisional asli Aceh kepada para pelajar. Beberapa warisan seni yang dikenalkan secara interaktif meliputi alat musik Rapa\'i, Serune Kalee, hingga tarian Ranup Lampuan dan Ratoh Jaroe. Sumber: UnimalNews',
                        'tanggal_mulai' => '2025-09-23',
                        'tanggal_selesai' => '2025-09-24',
                        'tempat' => 'SMA Negeri 7 Lhokseumawe dan SMK Negeri 3 Lhokseumawe.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Pelatihan Tarian Ratoh Jaroe bagi Mahasiswa Pertukaran Mahasiswa Merdeka (PMM)',
                        'deskripsi' => 'Pengurus dan instruktur dari UKM Meurah Silue mendedikasikan waktu selama dua bulan untuk melatih kesenian tari Ratoh Jaroe kepada para mahasiswa program inbound PMM Angkatan III dari berbagai penjuru luar Aceh. Kegiatan ini ditujukan agar para mahasiswa luar daerah dapat membawa pulang pemahaman mendalam tentang identitas seni gerak Aceh. Sumber: UnimalNews',
                        'tanggal_mulai' => '2023-11-01',
                        'tanggal_selesai' => '2023-12-31',
                        'tempat' => 'Aula Cut Meutia, Kampus Bukit Indah, Lhokseumawe.',
                        'jenis' => 'pelatihan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Pengenalan Budaya Aceh Bersama Mahasiswa Internasional (Kolaborasi dengan ECL)',
                        'deskripsi' => 'Bekerja sama dengan English Club/Language (ECL) Unimal, UKM Seni Budaya menyuguhkan pengenalan budaya komprehensif bagi mahasiswa internasional. Materi kebudayaan yang dipresentasikan mencakup demonstrasi langsung alat musik tradisional serta filosofi dari gerakan tarian khas daerah Aceh. Sumber: UnimalNews',
                        'tanggal_mulai' => '2024-05-17',
                        'tanggal_selesai' => '2024-05-17',
                        'tempat' => 'Guest House Universitas Malikussaleh.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ]
                ]
            ],

            // 3. UKM Sains, Riset, dan Robotika (UKM SRR)
            [
                'match_name' => '%SRR%',
                'profil' => [
                    'deskripsi' => 'UKM SRR merupakan organisasi kemahasiswaan di Universitas Malikussaleh yang bergerak secara aktif di bidang keilmuan, penelitian, riset ilmiah, serta pengembangan inovasi teknologi tepat guna. Organisasi ini didirikan untuk mendidik generasi muda agar sadar akan pentingnya sains dan teknologi masa depan.',
                    'bidang' => 'Sains, Riset/Penelitian Ilmiah, Robotika, Elektronika Otomatis, Kepemimpinan, dan Pengabdian Masyarakat Berbasis Teknologi.',
                ],
                'prestasi' => [
                    [
                        'nama_prestasi' => 'Peringkat III Terbaik Nasional Kategori Sistem Pendukung Organisasi Mahasiswa pada Abdidaya Ormawa 2024',
                        'tingkat' => 'nasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Tim UKM SRR meraih penghargaan nasional tertinggi sebagai ormawa dengan dukungan riil terlengkap. Prestasi ini membuktikan keunggulan tata kelola sistem pendukung organisasi kemahasiswaan Unimal di kancah nasional. Penyelenggara: Direktorat Jenderal Pendidikan Tinggi, Riset, dan Teknologi (Ditjen Diktiristek) melalui Belmawa Kemdikbudristek di Universitas Udayana, Bali. Hasil: Peringkat III Terbaik Nasional. Penerima: Tim PPK Ormawa UKM SRR Universitas Malikussaleh. Sumber: UnimalNews',
                        'penerima_raw' => 'Tim PPK Ormawa UKM SRR',
                    ],
                    [
                        'nama_prestasi' => 'Lolos Pendanaan dan Finalis Top 160 Besar Nasional Ajang PPK Ormawa 2024',
                        'tingkat' => 'nasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'UKM SRR mencetak sejarah sebagai organisasi mahasiswa pertama dari Universitas Malikussaleh yang berhasil menembus final nasional Abdidaya. Mereka berhasil lolos setelah menyisihkan 2.289 subproposal kompetitif dari berbagai perguruan tinggi se-Indonesia. Penyelenggara: Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi (Kemdikbudristek). Hasil: Lolos Pendanaan Nasional & Melaju ke Babak Final Abdidaya. Penerima: Tim PPK Ormawa UKM SRR Unimal (Ketua Tim: Rahmatul Maulana). Sumber: UnimalNews',
                        'penerima_raw' => 'Rahmatul Maulana',
                    ],
                    [
                        'nama_prestasi' => 'Keberhasilan Implementasi Inovasi Eco-Water Tank & Pompa Panel Surya Desa Rayeuk Kareung',
                        'tingkat' => 'nasional', // 'Regional / Nasional' -> Nasional
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Tim UKM SRR sukses merancang bangun teknologi Eco-Water Tank untuk memanen air hujan serta mengaplikasikan pompa air berbasis panel surya. Inovasi lingkungan ini berhasil menawarkan solusi konkret atas bencana banjir musiman dan kekeringan bagi masyarakat gampong. Kompetisi: Penilaian Akhir & Monitoring Evaluasi Program Konservasi Air Nasional Belmawa. Penyelenggara: Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi bekerjasama dengan Pemerintah Kota Lhokseumawe. Hasil: Sukses Diimplementasikan & Mendapat Apresiasi Resmi Pj Walikota Lhokseumawe. Penerima: Tim Inovator PPK Ormawa UKM SRR Unimal. Sumber: Website Resmi UKM SRR Unimal',
                        'penerima_raw' => 'Tim Inovator PPK Ormawa UKM SRR',
                    ]
                ],
                'kegiatan' => [
                    [
                        'nama' => 'Talk Show "Future Ready: AI, Digital & Entrepreneurship"',
                        'deskripsi' => 'UKM SRR sukses menggelar forum teknologi akbar bertajuk Future Ready bagi kalangan mahasiswa. Kegiatan ini mengupas tuntas integrasi pemanfaatan kecerdasan buatan (AI), platform digital, serta dunia wirausaha masa kini. Sumber: Website Resmi UKM SRR Unimal',
                        'tanggal_mulai' => '2025-10-09',
                        'tanggal_selesai' => '2025-10-09',
                        'tempat' => 'Aula Gedung PKM Universitas Malikussaleh, Kampus Bukit Indah, Lhokseumawe.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Pendidikan dan Latihan (DIKLAT) Angkatan XIII',
                        'deskripsi' => 'Kegiatan tahunan ini dilaksanakan untuk menyambut sekaligus membekali para kader baru organisasi. Fokus utama pelatihan meliputi pengembangan kapasitas kepemimpinan inovatif, materi riset ilmiah, dasar robotika, serta elektronika otomatis. Sumber: UnimalNews',
                        'tanggal_mulai' => '2024-11-01',
                        'tanggal_selesai' => '2024-11-30',
                        'tempat' => 'Aula FISIP Kampus Bukit Indah, Lhokseumawe.',
                        'jenis' => 'pelatihan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Aksi Sosial Ramadhan "BERLIAN 2025" (Berbagi Kemuliaan di Bulan Ramadhan)',
                        'deskripsi' => 'Kegiatan yang diinisiasi oleh Divisi Eksternal UKM SRR ini berjalan sukses dengan mengusung misi kepedulian sosial. Agenda diisi dengan aksi pembagian paket takjil gratis kepada masyarakat yang membutuhkan serta ditutup dengan buka puasa bersama seluruh pengurus. Sumber: UnimalNews',
                        'tanggal_mulai' => '2025-03-12',
                        'tanggal_selesai' => '2025-03-12',
                        'tempat' => 'Masjid Islamic Center Kota Lhokseumawe dan area sekitarnya.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ]
                ]
            ],

            // 4. UKM Formadiksi Unimal
            [
                'match_name' => '%Formadiksi%',
                'profil' => [
                    'deskripsi' => 'UKM Formadiksi Unimal merupakan wadah resmi bagi seluruh mahasiswa penerima beasiswa Bidikmisi dan Kartu Indonesia Pintar Kuliah (KIP Kuliah) di lingkungan Universitas Malikussaleh. Organisasi ini berfungsi sebagai sarana pengembangan diri, advokasi kesejahteraan beasiswa, pembinaan karakter, serta pendorong pencapaian prestasi akademik dan non-akademik anggotanya.',
                    'bidang' => 'Advokasi Beasiswa, Penalaran dan Riset Ilmiah (Karya Tulis/Esai), Pemberdayaan Kewirausahaan (Entrepreneurship), Minat dan Bakat, serta Pengabdian Sosial Masyarakat.',
                ],
                'prestasi' => [
                    [
                        'nama_prestasi' => 'Juara Umum dan Medali Emas Cabang Karya Tulis Ilmiah (Kategori Pariwisata) Timpresnas 2024',
                        'tingkat' => 'nasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Tim delegasi riset dari Formadiksi Unimal sukses keluar sebagai Juara Umum setelah merengkuh medali emas pada sub-kategori pariwisata. Prestasi gemilang berskala nasional ini diraih berkat pemaparan inovasi penulisan ilmiah yang matang di depan dewan juri. Penyelenggara: Universitas Pembangunan Panca Budi, Medan. Hasil: Juara Umum dan Medali Emas (Gold Medal). Penerima: Fadlin Hasan, Putri Manda Sari, dan Adrian. Sumber: UnimalNews',
                        'penerima_raw' => 'Fadlin Hasan',
                    ],
                    [
                        'nama_prestasi' => 'Medali Emas Cabang Esai Ilmiah Timpresnas 2024',
                        'tingkat' => 'nasional',
                        'tanggal' => '2024-01-01',
                        'deskripsi' => 'Anggota Formadiksi Unimal di cabang kompetisi esai juga sukses membawa pulang penghargaan tertinggi berupa medali emas. Ide solutif yang dituangkan dalam esai ilmiah tersebut berhasil menyisihkan kontestan dari berbagai perguruan tinggi nasional lainnya. Penyelenggara: Universitas Pembangunan Panca Budi, Medan. Hasil: Medali Emas (Gold Medal). Penerima: Muhammad Ahnaf Raid Yosna dan Nurul Azizah.',
                        'penerima_raw' => 'Muhammad Ahnaf Raid Yosna',
                    ],
                    [
                        'nama_prestasi' => 'Juara 1 Lomba Kisah Inspiratif Timdiksi Nasional 2023',
                        'tingkat' => 'nasional',
                        'tanggal' => '2023-01-01',
                        'deskripsi' => 'Fathia Balqis yang merupakan mahasiswi Akuntansi sekaligus kader Formadiksi Unimal meraih podium pertama lewat karya tulisan nyata berjudul "Juang dalam Nikmat-Nya". Ia sukses mengalahkan total 15 finalis nasional terpilih dari 12 universitas ternama di Indonesia. Penyelenggara: Forum Mahasiswa Pembidik Prestasi (Formadiksi) Universitas Mataram. Hasil: Juara 1. Penerima: Fathia Balqis. Sumber: UnimalNews',
                        'penerima_raw' => 'Fathia Balqis',
                    ]
                ],
                'kegiatan' => [
                    [
                        'nama' => 'Pekan Kreativitas Mahasiswa Nasional Unimal Bidikmisi Competitions (PKMN UBC) Jilid ke-5',
                        'deskripsi' => 'PKMN UBC merupakan program kerja unggulan akbar tahunan yang diinisiasi oleh Formadiksi Unimal. Pada jilid ke-5 ini, kegiatan tersebut dihadiri langsung oleh delegasi mahasiswa berprestasi dari 17 perguruan tinggi di seluruh penjuru Indonesia. Sumber: UnimalNews',
                        'tanggal_mulai' => '2025-07-01',
                        'tanggal_selesai' => '2025-07-31',
                        'tempat' => 'Kampus Universitas Malikussaleh, Lhokseumawe.',
                        'jenis' => 'lomba',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Seminar Kewirausahaan "Entrepreneurship and Achievement Day"',
                        'deskripsi' => 'Kegiatan ini digelar dengan target utama meningkatkan kompetensi kewirausahaan di kalangan mahasiswa penerima KIP Kuliah. Acara ini dihadiri dan diapresiasi penuh oleh Rektor Universitas Malikussaleh guna mendorong kemandirian ekonomi mahasiswa. Sumber: UnimalNews',
                        'tanggal_mulai' => '2025-11-01',
                        'tanggal_selesai' => '2025-11-30',
                        'tempat' => 'Aula Universitas Malikussaleh.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Program Edukasi dan Sosialisasi KIP-K Goes to School se-Aceh',
                        'deskripsi' => 'Formadiksi Unimal menerjunkan tim khusus ke lima kabupaten/kota di Aceh untuk mengedukasi para siswa sekolah menengah mengenai teknis pendaftaran KIP Kuliah. Kegiatan ini bertujuan memotivasi siswa kurang mampu agar tidak putus asa dan tetap bersemangat melanjutkan kuliah. Sumber: UnimalNews',
                        'tanggal_mulai' => '2024-11-16',
                        'tanggal_selesai' => '2024-11-16',
                        'tempat' => 'Lhokseumawe, Aceh Utara, Aceh Timur, Bener Meriah, dan Bireuen.',
                        'jenis' => 'kegiatan',
                        'status' => 'selesai',
                    ]
                ]
            ],

            // 5. UKM Olahraga
            [
                'match_name' => '%Olahraga%',
                'profil' => [
                    'deskripsi' => 'UKM Olahraga Universitas Malikussaleh merupakan organisasi kemahasiswaan intra-universitas resmi di lingkungan UNIMAL yang berfungsi sebagai wadah untuk menampung, menyalurkan, dan membina minat, bakat, serta potensi mahasiswa di bidang keolahragaan. Organisasi ini aktif mencetak atlet-atlet mahasiswa berprestasi yang mengharumkan nama universitas baik di tingkat daerah maupun nasional.',
                    'bidang' => 'Pembinaan olahraga prestasi, sportivitas, dan kerja sama tim yang menaungi berbagai cabang olahraga (cabor) seperti Futsal, Bulu Tangkis, Bola Basket, Pencak Silat, Tenis Lapangan, Catur, dan Karate.',
                ],
                'prestasi' => [
                    [
                        'nama_prestasi' => 'Juara 1 dan Medali Emas Cabang Olahraga Futsal POMDA Aceh 2023',
                        'tingkat' => 'regional',
                        'tanggal' => '2023-01-01',
                        'deskripsi' => 'Tim Futsal kebanggaan Unimal keluar sebagai juara setelah menaklukkan tim Poliven di babak final dengan skor akhir 5-3. Sebelumnya, tim ini juga sukses menumbangkan juara bertahan Universitas Syiah Kuala (USK) di babak perempat final melalui pertandingan sengit. Penyelenggara: Badan Pembina Olahraga Mahasiswa Indonesia (BAPOMI) Aceh bersama Universitas Malikussaleh. Hasil: Juara 1 / Medali Emas. Penerima: Tim Futsal Universitas Malikussaleh (diarsiteki oleh Head Coach M. Mulakkin Assaudy MSM dan Manajer Ferdy Saputra). Sumber: UnimalNews',
                        'penerima_raw' => 'Tim Futsal Universitas Malikussaleh',
                    ],
                    [
                        'nama_prestasi' => 'Juara Umum Cabang Olahraga Bulutangkis POMDA Aceh 2023',
                        'tingkat' => 'regional',
                        'tanggal' => '2023-01-01',
                        'deskripsi' => 'Delegasi atlet bulutangkis Unimal tampil mendominasi dengan mengoleksi total delapan medali sepanjang turnamen. Medali emas masing-masing diraih melalui kategori beregu putri serta tiga nomor pertandingan perorangan lainnya. Penyelenggara: BAPOMI Aceh bersama Universitas Malikussaleh. Hasil: Juara Umum Cabang Olahraga Bulutangkis (4 Emas, 1 Perak, 3 Perunggu). Penerima: Tim Bulutangkis Universitas Malikussaleh. Sumber: UnimalNews',
                        'penerima_raw' => 'Tim Bulutangkis Universitas Malikussaleh',
                    ],
                    [
                        'nama_prestasi' => 'Juara Umum Cabang Olahraga Tenis Lapangan POMDA Aceh 2023',
                        'tingkat' => 'regional',
                        'tanggal' => '2023-01-01',
                        'deskripsi' => 'Atlet tenis lapangan Unimal memborong podium utama pada nomor pertandingan Tunggal Putra, Ganda Putra, serta Ganda Putri. Berkat prestasi gemilang ini, tim berhasil mengamankan tiket menuju Pekan Olahraga Mahasiswa Nasional (POMNAS) 2023 di Kalimantan Selatan. Penyelenggara: BAPOMI Aceh bersama Universitas Malikussaleh. Hasil: Juara Umum Cabang Olahraga Tenis Lapangan (3 Emas dan 2 Perak). Penerima: Tim Tenis Lapangan Unimal (Fathir Muhammad, Hasundutan, Taradisa Angeli Tanura, dan Lala Gita Natasya). Sumber: UnimalNews',
                        'penerima_raw' => 'Fathir Muhammad',
                    ]
                ],
                'kegiatan' => [
                    [
                        'nama' => 'Penyelenggaraan Turnamen Multi-Event "UKM Olahraga Cup I"',
                        'deskripsi' => 'UKM Olahraga menginisiasi turnamen akbar bertajuk UKM Olahraga Cup I yang memperlombakan beberapa cabang olahraga secara masif. Kompetisi ini meliputi cabang Bulu Tangkis, Turnamen Bola Basket 5x5 antar-fakultas, hingga kejuaraan Pencak Silat mahasiswa se-Provinsi Aceh. Tujuan: Menjadi wadah silaturahmi antar-atlet mahasiswa, menyaring potensi bibit baru di lingkungan kampus, serta meningkatkan jam terbang atlet dalam menyongsong ajang kejuaraan daerah maupun nasional. Sumber: Instagram @ukm.badminton_unimal & LDII Lhokseumawe',
                        'tanggal_mulai' => '2025-11-10',
                        'tanggal_selesai' => '2025-11-15',
                        'tempat' => 'Gelanggang Olahraga (GOR) dan lapangan internal Universitas Malikussaleh.',
                        'jenis' => 'lomba',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Panitia Pelaksana Teknis Lapangan Pekan Olahraga Mahasiswa Daerah (POMDA) Aceh 2023',
                        'deskripsi' => 'Ketika Universitas Malikussaleh dipercaya menjadi tuan rumah POMDA Aceh 2023, pengurus serta kader UKM Olahraga dikerahkan sebagai bagian inti kepanitiaan pelaksana teknis. Mereka mendampingi jalannya pertandingan di 16 cabang olahraga yang diikuti oleh total 1.013 atlet dari 28 perguruan tinggi se-Aceh. Tujuan: Memastikan kelancaran kompetisi olahraga mahasiswa terbesar di tingkat provinsi serta menyukseskan seleksi delegasi menuju POMNAS Kalimantan Selatan. Sumber: UnimalNews (Pembukaan POMDA) & UnimalNews (Tuan Rumah POMDA)',
                        'tanggal_mulai' => '2023-09-16',
                        'tanggal_selesai' => '2023-09-23',
                        'tempat' => 'Kampus Bukit Indah, GOR Unimal, dan Gedung Academic Center (ACC) Cunda, Lhokseumawe.',
                        'jenis' => 'lomba',
                        'status' => 'selesai',
                    ],
                    [
                        'nama' => 'Seleksi Terbuka dan Pembinaan Rutin Atlet Futsal Universitas Malikussaleh',
                        'deskripsi' => 'Divisi Cabang Olahraga Futsal di bawah naungan UKM Olahraga melaksanakan program seleksi ketat yang terbuka bagi seluruh mahasiswa aktif lintas fakultas. Agenda ini dilanjutkan dengan pembinaan fisik dan taktik secara intensif untuk membentuk kedalaman skuad utama. Tujuan: Menjaring talenta-talenta terbaik dari kalangan mahasiswa demi membentuk komposisi tim yang tangguh untuk menembus babak final kejuaraan daerah. Sumber: UnimalNews',
                        'tanggal_mulai' => '2022-08-01',
                        'tanggal_selesai' => '2022-08-31',
                        'tempat' => 'Lapangan Futsal internal / Lingkungan Kampus Unimal Lhokseumawe.',
                        'jenis' => 'pelatihan',
                        'status' => 'selesai',
                    ]
                ]
            ]
        ];

        $matchedUkms = [];
        $unmatchedUkms = [];

        foreach ($ukmData as $data) {
            $ukm = Ukm::where('nama', 'like', $data['match_name'])->first();

            if ($ukm) {
                $matchedUkms[] = $ukm->nama;
                
                // Update UKM profile
                $updateData = [];
                if (!empty($data['profil']['deskripsi'])) {
                    $updateData['deskripsi'] = $data['profil']['deskripsi'];
                }
                if (!empty($data['profil']['bidang'])) {
                    $updateData['bidang'] = substr($data['profil']['bidang'], 0, 50);
                }
                
                if (!empty($updateData)) {
                    $ukm->update($updateData);
                }

                // Insert Prestasi
                foreach ($data['prestasi'] as $pres) {
                    $userId = null;
                    if (!empty($pres['penerima_raw'])) {
                        $user = User::where('name', $pres['penerima_raw'])->first();
                        if ($user) {
                            $userId = $user->id;
                        }
                    }

                    Prestasi::firstOrCreate(
                        [
                            'ukm_id' => $ukm->id,
                            'nama_prestasi' => $pres['nama_prestasi'],
                        ],
                        [
                            'user_id' => $userId,
                            'tingkat' => $pres['tingkat'],
                            'tanggal' => $pres['tanggal'],
                            'deskripsi' => $pres['deskripsi'],
                            'piagam' => null,
                        ]
                    );
                }

                // Insert Kegiatan
                foreach ($data['kegiatan'] as $keg) {
                    Kegiatan::firstOrCreate(
                        [
                            'ukm_id' => $ukm->id,
                            'nama' => $keg['nama'],
                        ],
                        [
                            'deskripsi' => $keg['deskripsi'],
                            'tanggal_mulai' => $keg['tanggal_mulai'],
                            'tanggal_selesai' => $keg['tanggal_selesai'],
                            'tempat' => $keg['tempat'],
                            'jenis' => $keg['jenis'],
                            'status' => $keg['status'],
                        ]
                    );
                }
            } else {
                $unmatchedUkms[] = $data['match_name'];
            }
        }

        echo "Seeder Selesai!\n";
        echo "UKM Berhasil Dicocokkan:\n";
        foreach ($matchedUkms as $name) {
            echo "- " . $name . "\n";
        }

        if (!empty($unmatchedUkms)) {
            echo "\nUKM Gagal Dicocokkan:\n";
            foreach ($unmatchedUkms as $name) {
                echo "- " . $name . "\n";
            }
        }
    }
}

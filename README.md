# Sistem Informasi Unit Kegiatan Mahasiswa (UKM) Universitas Malikussaleh

Website berbasis Laravel untuk menyediakan informasi Unit Kegiatan Mahasiswa (UKM), kegiatan, prestasi, berita, struktur organisasi, serta proses pendaftaran anggota secara online.

Project ini juga menyediakan area administrator untuk mengelola data UKM, anggota, kepengurusan, divisi, kegiatan, prestasi, berita, dan pendaftaran mahasiswa.

---

## 📌 Tentang Project

Website ini dirancang sebagai pusat informasi dan manajemen UKM di lingkungan Universitas Malikussaleh.

Pengunjung dapat melihat informasi UKM tanpa harus login. Mahasiswa yang ingin mendaftar menjadi anggota dapat membuat akun, login menggunakan NIM, kemudian mengajukan pendaftaran ke UKM yang tersedia.

Administrator memiliki halaman login khusus dan dapat mengelola seluruh data yang berkaitan dengan UKM dan keanggotaan.

### Tujuan utama

- Menyediakan informasi UKM secara terpusat.
- Menampilkan profil, kegiatan, prestasi, berita, dan struktur organisasi setiap UKM.
- Memudahkan mahasiswa melakukan pendaftaran UKM secara online.
- Membantu admin memverifikasi pendaftaran anggota.
- Mengelola struktur kepengurusan dan divisi UKM.
- Menyediakan dashboard statistik dan aktivitas sistem.

---

# 🛠️ Teknologi yang Digunakan

- **PHP 8.3+**
- **Laravel 13**
- **MySQL / database yang didukung Laravel**
- **Blade Template**
- **Tailwind CSS 4**
- **Vite 8**
- **Laravel Notifications**
- **Laravel Eloquent ORM**
- **Composer**
- **NPM**

Versi dependency utama dapat dilihat pada `composer.json` dan `package.json`.

---

# 👥 Role Pengguna

Sistem memiliki dua role utama:

| Role | Akses |
|---|---|
| Pengunjung | Melihat informasi publik tanpa login |
| User / Mahasiswa | Login, melihat informasi, mendaftar UKM, melihat status pendaftaran, mengelola profil |
| Admin | Mengelola UKM, anggota, pendaftaran, kepengurusan, divisi, kegiatan, prestasi, berita, dan notifikasi |

---

# 🌐 1. Alur Pengunjung

Website dapat dibuka tanpa login.

Alur dasarnya:

```text
Landing Page
    │
    ├── Melihat daftar UKM
    │       │
    │       └── Detail UKM
    │              ├── Profil UKM
    │              ├── Struktur Organisasi
    │              ├── Divisi
    │              ├── Kegiatan
    │              ├── Prestasi
    │              └── Berita
    │
    ├── Melihat kegiatan
    │
    ├── Melihat prestasi
    │
    ├── Melihat berita
    │
    ├── Login User
    │
    ├── Register
    │
    └── Login Admin
```

Landing page menampilkan statistik seperti:

- Jumlah UKM aktif
- Jumlah mahasiswa
- Jumlah pendaftaran
- Jumlah kegiatan
- Berita terpilih
- Daftar UKM aktif

---

# 🔐 2. Sistem Login User / Mahasiswa

Login user menggunakan **NIM dan password**.

Route:

```text
GET  /login
POST /login
```

File halaman:

```text
resources/views/auth/login.blade.php
```

Proses login ditangani oleh:

```text
app/Http/Controllers/AuthController.php
```

### Alur login user

```text
Halaman Login
     │
     ▼
Masukkan NIM + Password
     │
     ▼
Validasi
     │
     ├── Salah ──► Pesan error
     │
     └── Benar
          │
          ▼
     Cek Role
          │
          ├── Admin ──► Ditolak dari login user
          │
          └── User ──► Login berhasil
                         │
                         ▼
                    Landing Page
```

Sistem juga memiliki pembatasan percobaan login untuk membantu mencegah percobaan login berulang.

---

# 📝 3. Registrasi Akun User

Mahasiswa yang belum memiliki akun dapat melakukan registrasi.

Route:

```text
GET  /register
POST /register
```

Halaman:

```text
resources/views/auth/register.blade.php
```

Data yang digunakan antara lain:

- Nama
- NIM
- Email
- Password
- Fakultas
- Program Studi
- Angkatan

Setelah registrasi berhasil, user langsung login dan diarahkan ke landing page.

---

# 🔑 4. Login Admin

Login admin dibuat terpisah dari login mahasiswa.

Route:

```text
GET  /login/admin
POST /login/admin
```

Halaman:

```text
resources/views/auth/admin-login.blade.php
```

Login admin menggunakan:

- royyan.240170179@mhs.unimal.ac.id
- admin1234

Setelah berhasil, admin diarahkan ke:

```text
/admin/dashboard
```

Sistem juga memastikan bahwa akun yang digunakan benar-benar memiliki role:

```text
admin
```

Akun user biasa tidak dapat masuk melalui halaman login admin.

> **Keamanan:** jangan menuliskan password admin asli di README publik. Gunakan akun demo khusus atau ubah password akun administrator sebelum repository dibagikan.

---

# 🚪 5. Logout

Logout menggunakan:

```text
POST /logout
```

Setelah logout:

```text
User/Admin
    │
    ▼
Session dihapus
    │
    ▼
Kembali ke Landing Page
```

Session juga diregenerasi untuk meningkatkan keamanan autentikasi.

---

# 👤 6. Fitur User / Mahasiswa Setelah Login

User yang sudah login dapat mengakses:

```text
/daftar
/status-pendaftaran
/profil
```

## Daftar UKM

Route:

```text
GET /daftar
```

User dapat melihat UKM yang tersedia dan memilih UKM yang ingin didaftarkan.

## Form Pendaftaran

Route:

```text
GET /daftar/{ukm}/create
POST /daftar
```

Data pendaftaran meliputi:

- UKM
- Nomor HP
- Fakultas
- Program Studi
- Angkatan
- Alasan bergabung
- KTM (opsional)

Setelah dikirim, status pendaftaran menjadi:

```text
pending
```

---

# 🔄 7. Aturan Pendaftaran UKM

Sistem memiliki beberapa validasi agar pendaftaran tidak dapat dimanipulasi.

### Jika masih memiliki pendaftaran pending

User tidak dapat membuat pendaftaran baru sampai admin memberikan keputusan.

### Jika sudah diterima

User tidak dapat mendaftar ke UKM lain.

### Jika pernah ditolak pada UKM tertentu

User tidak dapat mengajukan ulang ke UKM yang sama.

### Jika sudah pernah memiliki record pendaftaran

Sistem mencegah pendaftaran ganda akibat refresh atau double-click.

Alurnya:

```text
User
 │
 ▼
Pilih UKM
 │
 ▼
Isi Form Pendaftaran
 │
 ▼
Validasi Sistem
 │
 ├── Tidak memenuhi aturan
 │       └── Ditolak + pesan error
 │
 └── Valid
       │
       ▼
   Status = Pending
       │
       ▼
   Admin menerima notifikasi
```

---

# 🔗 8. Form Pendaftaran Eksternal UKM

UKM dapat memiliki `link_pendaftaran`.

Jika link tersebut tersedia dan merupakan URL valid, setelah pendaftaran awal berhasil user dapat diarahkan ke formulir eksternal UKM, misalnya Google Form.

Alurnya:

```text
Pendaftaran Website
       │
       ▼
Status Pending
       │
       ▼
Notifikasi Admin
       │
       ▼
Link Pendaftaran UKM
       │
       ▼
Form Eksternal
```

---

# 📊 9. Status Pendaftaran

User dapat melihat riwayat pendaftarannya melalui:

```text
/status-pendaftaran
```

Status yang digunakan:

- `pending`
- `diterima`
- `ditolak`

Jika ditolak, sistem juga dapat menyimpan alasan penolakan.

---

# 👤 10. Profil User

Route:

```text
GET /profil
PUT /profil
```

User dapat memperbarui:

- Nama
- Nomor HP
- Fakultas
- Program Studi
- Angkatan
- Foto profil

Foto disimpan menggunakan Laravel Storage.

---

# 🛡️ 11. Dashboard Admin

Dashboard admin:

```text
/admin/dashboard
```

Dashboard menampilkan statistik seperti:

- Jumlah UKM aktif
- Jumlah mahasiswa
- Jumlah anggota aktif
- Jumlah pendaftaran pending
- Jumlah prestasi

Dashboard juga memiliki:

- Pendaftaran terbaru
- Prestasi terbaru
- Aktivitas sistem
- Grafik aktivitas 30 hari
- Distribusi UKM berdasarkan bidang
- Notifikasi

---

# 🔔 12. Notifikasi Admin

Ketika mahasiswa mengirim pendaftaran UKM, sistem membuat notifikasi untuk admin.

Route:

```text
/admin/notifications
```

Admin dapat:

- Melihat notifikasi
- Menandai satu notifikasi sebagai dibaca
- Menandai seluruh notifikasi sebagai dibaca

Implementasi notifikasi:

```text
app/Notifications/NewRegistrationNotification.php
```

---

# 👥 13. Verifikasi Pendaftaran Anggota

Admin dapat membuka:

```text
/admin/keanggotaan
```

Data dikelompokkan berdasarkan status:

```text
Pending
Diterima
Ditolak
```

Admin dapat:

### Approve

Jika diterima:

```text
Pendaftaran
     │
     ▼
Status = diterima
     │
     ▼
Otomatis membuat data Kepengurusan
     │
     ▼
Jabatan awal = Anggota
```

Sistem juga menempatkan anggota baru ke divisi aktif pertama sebagai divisi default jika tersedia.

### Reject

Admin dapat menolak pendaftaran dan memberikan alasan penolakan.

---

# 🏢 14. Manajemen UKM

Admin dapat mengelola data UKM:

```text
/ukm
```

Fitur:

- Melihat UKM
- Menambah UKM
- Melihat detail UKM
- Mengedit UKM
- Menghapus UKM

Data UKM dapat mencakup:

- Nama
- Deskripsi
- Logo
- Bidang
- Email
- Telepon
- Alamat
- Status
- Link pendaftaran

---

# 👨‍💼 15. Manajemen Anggota

Admin dapat melihat anggota melalui:

```text
/user
```

Anggota ditampilkan berdasarkan data kepengurusan.

Admin dapat:

- Melihat detail anggota
- Mengubah jabatan
- Mengubah status anggota
- Mengelola data kepengurusan

Anggota **tidak ditambahkan secara manual melalui menu user**. Anggota baru dibuat otomatis ketika pendaftaran mahasiswa disetujui.

---

# 🏛️ 16. Struktur Organisasi dan Kepengurusan

Setiap UKM dapat memiliki struktur organisasi.

Data yang digunakan:

```text
UKM
 │
 ├── Ketua Umum
 ├── Wakil Ketua
 ├── Sekretaris
 ├── Bendahara
 │
 └── Divisi
       ├── Kepala Divisi
       ├── Sekretaris Divisi
       └── Anggota
```

Kepengurusan terhubung dengan:

- User
- UKM
- Jabatan
- Divisi

Admin dapat menambah, mengubah, menghapus, dan mengatur status kepengurusan.

---

# 🗂️ 17. Divisi

Divisi dimiliki oleh masing-masing UKM.

Contoh:

```text
UKM A
 ├── Divisi PSDM
 ├── Divisi Humas
 ├── Divisi Kreatif
 └── Divisi lainnya

UKM B
 ├── Divisi Akademik
 ├── Divisi Olahraga
 └── Divisi lainnya
```

Divisi tidak bersifat global sehingga setiap UKM dapat memiliki struktur divisinya sendiri.

---

# 📅 18. Kegiatan UKM

Admin dapat menambahkan dan menghapus kegiatan.

Data kegiatan meliputi:

- Nama kegiatan
- Deskripsi
- Tanggal mulai
- Tanggal selesai
- Tempat
- Jenis
- Status
- UKM

Pengunjung dapat melihat detail kegiatan melalui halaman publik.

---

# 🏆 19. Prestasi UKM

Admin dapat mengelola:

```text
/prestasi
```

Fitur:

- Tambah prestasi
- Lihat prestasi
- Detail prestasi
- Edit prestasi
- Hapus prestasi

Data prestasi terhubung dengan UKM dan dapat mencatat:

- Nama prestasi
- Tingkat
- Tanggal
- Deskripsi
- Piagam/dokumen

Prestasi juga dapat ditampilkan pada halaman publik.

---

# 📰 20. Berita UKM

Admin dapat mengelola berita:

```text
/berita
```

Fitur:

- Membuat berita
- Mengedit berita
- Menghapus berita
- Mengatur status publikasi
- Menentukan apakah berita ditampilkan pada dashboard

Berita yang berstatus `published` dan diaktifkan untuk dashboard dapat muncul pada landing page.

---

# 🧩 Struktur Route Utama

Secara sederhana:

```text
/
├── /login
├── /login/admin
├── /register
├── /logout
│
├── /informasi-ukm/{ukm}
├── /kegiatan/{kegiatan}
├── /prestasi-publik/{prestasi}
│
├── /daftar
├── /daftar/{ukm}/create
├── /status-pendaftaran
└── /profil

ADMIN
│
├── /admin/dashboard
├── /admin/keanggotaan
├── /admin/notifications
│
├── /ukm
├── /user
├── /prestasi
├── /berita
├── /kegiatan
├── /kepengurusan
└── /ukm/{ukm}/divisi
```

Route lengkap dapat dilihat di:

```text
routes/web.php
```

---

# 🔒 Middleware

Project menggunakan middleware untuk membatasi halaman tertentu.

## `member`

File:

```text
app/Http/Middleware/EnsureUserIsMember.php
```

Digunakan untuk halaman yang membutuhkan user sudah login.

## `admin`

File:

```text
app/Http/Middleware/EnsureUserIsAdmin.php
```

Digunakan untuk halaman administrator.

Alur:

```text
Request
   │
   ▼
Middleware
   │
   ├── Belum login ──► Login
   │
   ├── Bukan admin ─► Ditolak / diarahkan
   │
   └── Valid ───────► Controller
```

---

# 🗄️ Database

Beberapa tabel utama yang digunakan:

```text
users
ukms
jabatans
kepengurusans
divisis
keanggotaans
kegiatans
prestasis
beritas
notifications
```

Relasi sederhananya:

```text
users
 │
 ├──────── keanggotaans ────────► ukms
 │                                  │
 │                                  ├── kegiatans
 │                                  ├── prestasis
 │                                  ├── beritas
 │                                  ├── divisis
 │                                  └── kepengurusans
 │
 └──────── kepengurusans ───────► jabatans
```

Migration database berada di:

```text
database/migrations/
```

---

# 📂 Struktur Folder Penting

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── BeritaController.php
│   │   ├── DashboardController.php
│   │   ├── DivisiController.php
│   │   ├── KeanggotaanController.php
│   │   ├── KegiatanController.php
│   │   ├── KepengurusanController.php
│   │   ├── PrestasiController.php
│   │   ├── UkmController.php
│   │   └── UserController.php
│   │
│   └── Middleware/
│       ├── EnsureUserIsAdmin.php
│       └── EnsureUserIsMember.php
│
├── Models/
├── Notifications/
└── Providers/

database/
├── migrations/
└── seeders/

resources/
└── views/
    ├── admin/
    ├── auth/
    ├── berita/
    ├── layouts/
    ├── prestasi/
    ├── public/
    ├── ukm/
    └── user/

routes/
└── web.php
```

---

# 🚀 Instalasi Project

## 1. Clone repository

```bash
git clone https://github.com/USERNAME/NAMA-REPOSITORY.git
```

Masuk ke folder:

```bash
cd medan
```

## 2. Install dependency PHP

```bash
composer install
```

## 3. Buat file `.env`

Windows:

```bash
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

## 4. Generate application key

```bash
php artisan key:generate
```

## 5. Konfigurasi database

Buka:

```text
.env
```

Contoh konfigurasi MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan database lokal.

## 6. Jalankan migration

```bash
php artisan migrate
```

Jika ingin membuat database beserta data dummy dari awal:

```bash
php artisan migrate:fresh --seed
```

> `migrate:fresh --seed` akan menghapus tabel yang ada dan membuat ulang database berdasarkan migration + seeder. Jangan menjalankan perintah ini pada database produksi tanpa memahami akibatnya.

## 7. Install dependency frontend

```bash
npm install
```

## 8. Build frontend

```bash
npm run build
```

## 9. Jalankan server

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

---

# ⚡ Mode Development

Untuk development, project juga menyediakan script:

```bash
npm run dev
```

dan Laravel:

```bash
php artisan serve
```

Project `composer.json` juga menyediakan script `dev` untuk menjalankan server Laravel, queue listener, dan Vite secara bersamaan.

---

# 🌱 Seeder

Seeder utama:

```text
database/seeders/DatabaseSeeder.php
```

Seeder tersebut memanggil:

```text
JabatanSeeder
UkmSeeder
DivisiSeeder
DummyDataSeeder
```

Data dummy digunakan untuk membantu developer mempelajari tampilan dan alur sistem tanpa harus memasukkan seluruh data secara manual.

---

# 🔑 Akun Demo

Project memiliki akun admin yang dibuat oleh `DatabaseSeeder`.

Untuk keamanan, **jangan menggunakan password admin bawaan untuk deployment atau repository publik**.

Jika project akan dibagikan kepada orang lain, sebaiknya:

1. Buat akun demo khusus.
2. Gunakan password demo yang tidak digunakan di tempat lain.
3. Jangan memasukkan password pribadi ke README.
4. Ganti password administrator sebelum production.

User dummy dari `DummyDataSeeder` menggunakan password seed yang dibuat khusus untuk data pengujian.

---

# ⚠️ Keamanan Sebelum Push ke GitHub

Pastikan file rahasia tidak ikut masuk repository.

File `.env` seharusnya tidak di-push.

Project sudah memiliki:

```text
.env
```

di dalam `.gitignore`.

Jika `.env` pernah terlanjur di-commit atau di-push ke GitHub, hapus dari tracking Git dan **ganti semua credential/secret yang pernah berada di dalam file tersebut**, terutama:

- Password database
- `APP_KEY`
- Credential email
- API key
- Token
- Credential layanan pihak ketiga

Jangan hanya menghapus file dari folder lokal jika secret tersebut sudah pernah masuk ke riwayat Git.

---

# 🖼️ Storage File

Jika menggunakan file upload Laravel, buat symbolic link storage:

```bash
php artisan storage:link
```

Hal ini diperlukan agar file yang disimpan pada:

```text
storage/app/public
```

dapat diakses melalui:

```text
public/storage
```

---

# 🧪 Testing

Project menggunakan Pest/Laravel testing stack yang tersedia pada dependency development.

Untuk menjalankan test:

```bash
php artisan test
```

---

# 🧑‍💻 Panduan Belajar Project

Jika kamu ingin mempelajari project ini dari awal, urutan yang disarankan:

### 1. Pelajari route

Mulai dari:

```text
routes/web.php
```

Cari route:

```php
Route::get(...)
Route::post(...)
Route::put(...)
Route::delete(...)
```

Route menentukan URL dan controller yang menangani request.

### 2. Pelajari Controller

Setelah menemukan route, buka controller terkait:

```text
app/Http/Controllers/
```

Contoh:

```text
/login
      ↓
AuthController
      ↓
userLogin()
```

### 3. Pelajari Model

Controller menggunakan model:

```text
app/Models/
```

Contoh:

```text
Ukm
User
Keanggotaan
Kepengurusan
Kegiatan
Prestasi
Berita
Divisi
Jabatan
```

### 4. Pelajari View

Tampilan halaman berada di:

```text
resources/views/
```

Contoh alur:

```text
Route
  ↓
Controller
  ↓
Model / Database
  ↓
Blade View
  ↓
Browser
```

### 5. Pelajari Database

Migration berada di:

```text
database/migrations/
```

Sedangkan data awal/testing berada di:

```text
database/seeders/
```

---

# 🔁 Contoh Alur Lengkap Pendaftaran

Berikut contoh alur paling penting dalam sistem:

```text
Mahasiswa
   │
   ▼
Register
   │
   ▼
Login menggunakan NIM
   │
   ▼
Landing Page
   │
   ▼
Pilih UKM
   │
   ▼
Form Pendaftaran
   │
   ▼
Submit
   │
   ▼
Keanggotaan = Pending
   │
   ├──────────────► Notifikasi Admin
   │
   ▼
Admin membuka Pendaftaran
   │
   ├── Reject
   │      └── Status = Ditolak
   │
   └── Approve
          │
          ▼
      Status = Diterima
          │
          ▼
      Kepengurusan dibuat otomatis
          │
          ▼
      Jabatan = Anggota
          │
          ▼
      User menjadi anggota UKM
```

---

# 🏗️ Arsitektur Sederhana

Project menggunakan pola MVC Laravel:

```text
                 Browser
                    │
                    ▼
                  Route
                    │
                    ▼
               Controller
               /         \
              /           \
             ▼             ▼
          Model          Validation
             │
             ▼
          Database
             │
             ▼
          Controller
             │
             ▼
          Blade View
             │
             ▼
           Browser
```

---

# 📚 File Penting untuk Dipelajari

| File / Folder | Fungsi |
|---|---|
| `routes/web.php` | Semua route utama website |
| `app/Http/Controllers/AuthController.php` | Login, register, logout |
| `app/Http/Controllers/DashboardController.php` | Landing page dan dashboard admin |
| `app/Http/Controllers/KeanggotaanController.php` | Pendaftaran dan verifikasi anggota |
| `app/Http/Controllers/UkmController.php` | CRUD UKM |
| `app/Http/Controllers/UserController.php` | Data anggota |
| `app/Http/Controllers/KepengurusanController.php` | Struktur kepengurusan |
| `app/Http/Controllers/DivisiController.php` | Divisi UKM |
| `app/Http/Controllers/KegiatanController.php` | Kegiatan |
| `app/Http/Controllers/PrestasiController.php` | Prestasi |
| `app/Http/Controllers/BeritaController.php` | Berita |
| `app/Models/` | Representasi tabel database |
| `database/migrations/` | Struktur database |
| `database/seeders/` | Data awal/dummy |
| `resources/views/` | Tampilan Blade |
| `resources/css/` | Style |
| `resources/js/` | JavaScript/frontend |
| `vite.config.js` | Konfigurasi Vite |
| `composer.json` | Dependency PHP |
| `package.json` | Dependency frontend |

---

# 📌 Catatan Developer

Project ini dikembangkan menggunakan Laravel dan struktur MVC.

Sebelum mengubah kode, disarankan memahami hubungan:

```text
Route → Controller → Model → Database → View
```

Jika menambahkan fitur baru, periksa terlebih dahulu:

1. Apakah membutuhkan route baru?
2. Apakah membutuhkan controller?
3. Apakah membutuhkan model?
4. Apakah membutuhkan migration?
5. Apakah membutuhkan view?
6. Apakah membutuhkan middleware?
7. Apakah fitur tersebut membutuhkan perubahan database?
8. Apakah ada hubungan dengan fitur pendaftaran atau autentikasi?

---

# 📄 Lisensi

Project ini menggunakan struktur project Laravel. Lisensi dan penggunaan project dapat disesuaikan dengan kebutuhan pengembang/pemilik project.

---

# 👨‍💻 Developer

**Royyan Ramadhan**

Project:
**Sistem Informasi Unit Kegiatan Mahasiswa (UKM) Universitas Malikussaleh**


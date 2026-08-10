# 📚 UKM Management System

Sistem informasi manajemen Unit Kegiatan Mahasiswa (UKM) yang modern dan user-friendly dengan fitur CRUD lengkap, database terrelasi, dan UI yang menarik menggunakan Tailwind CSS.

## ✨ Fitur Utama

### 1. **Dashboard UKM** 
- 📊 Grid layout yang responsif menampilkan semua UKM
- 🏷️ Tag bidang dan status
- 👥 Menampilkan jumlah anggota struktural
- 📱 Responsive design (mobile, tablet, desktop)

### 2. **Manajemen UKM**
- ✅ Create - Tambah UKM baru
- 📖 Read - Lihat detail UKM
- ✏️ Update - Edit data UKM
- 🗑️ Delete - Hapus UKM
- 📸 Upload logo/foto UKM
- 📧 Kelola informasi kontak

### 3. **Struktur Organisasi (Org Chart)**
- 👑 Tampilan khusus untuk Ketua Umum
- 📊 Hierarchical display berdasarkan jabatan
- 🎖️ Daftar lengkap anggota dengan foto profil
- ➕ Tambah/Edit anggota ke struktur
- 🗑️ Hapus anggota dari struktur

### 4. **Manajemen Anggota**
- 📋 Daftar lengkap semua anggota
- 👤 Profil anggota dengan foto
- 📞 Informasi kontak anggota
- 🏢 Daftar UKM yang diikuti
- 💼 Jabatan di setiap UKM

### 5. **Fitur CRUD Lengkap**
- ✅ Create - Tambah data baru
- 📖 Read - Lihat detail data
- ✏️ Update - Edit data
- 🗑️ Delete - Hapus data

### 6. **Upload File**
- 📸 Upload foto profil anggota
- 🏛️ Upload logo/foto UKM
- 👁️ Preview gambar sebelum upload
- 💾 Penyimpanan di storage public
- 🔄 Update/ganti foto yang sudah ada

## 🗄️ Database Schema

### Tabel: `ukms`
```sql
- id (Primary Key)
- nama (String, Unique)
- deskripsi (Text)
- logo (String - path ke file)
- bidang (String)
- email (String)
- telepon (String)
- alamat (Text)
- status (Enum: aktif, nonaktif)
- timestamps (created_at, updated_at)
```

### Tabel: `jabatans`
```sql
- id (Primary Key)
- nama (String, Unique) - Ketua Umum, Wakil Ketua, Sekretaris Umum, etc
- deskripsi (Text)
- level (Integer) - Untuk hierarchical display
- timestamps
```

### Tabel: `kepengurusans` (Junction Table)
```sql
- id (Primary Key)
- ukm_id (Foreign Key → ukms)
- user_id (Foreign Key → users)
- jabatan_id (Foreign Key → jabatans)
- tanggal_mulai (Date)
- tanggal_akhir (Date)
- status (Enum: aktif, nonaktif)
- timestamps
- unique constraint: (ukm_id, user_id, jabatan_id)
```

### Tabel: `users` (Extended)
```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- password (String, Hashed)
- photo (String - path ke file) - NEW
- telepon (String) - NEW
- bio (Text) - NEW
- timestamps
```

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- Laravel 11
- MySQL/MariaDB
- Composer

### Installation

```bash
# 1. Clone atau masuk ke folder project
cd c:\xampp\htdocs\medan

# 2. Install dependencies
composer install

# 3. Copy .env file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure database di .env
DB_DATABASE=medan
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Seed dummy data
php artisan db:seed

# 8. Create storage symlink
php artisan storage:link

# 9. Start development server
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000/ukm`

## 📂 Struktur File

```
medan/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── UkmController.php         # CRUD UKM
│   │       ├── UserController.php        # CRUD User/Anggota
│   │       └── KepengurusanController.php # CRUD Kepengurusan
│   └── Models/
│       ├── Ukm.php
│       ├── User.php
│       ├── Jabatan.php
│       └── Kepengurusan.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_ukms_table.php
│   │   ├── ..._create_jabatans_table.php
│   │   ├── ..._create_kepengurusans_table.php
│   │   └── ..._add_photo_to_users_table.php
│   └── seeders/
│       ├── JabatanSeeder.php
│       ├── UkmSeeder.php
│       ├── KepengurusanSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php             # Master layout
│   │   ├── ukm/
│   │   │   ├── index.blade.php           # Dashboard UKM
│   │   │   ├── create.blade.php          # Form tambah UKM
│   │   │   ├── edit.blade.php            # Form edit UKM
│   │   │   └── show.blade.php            # Detail + Org Chart
│   │   └── user/
│   │       ├── index.blade.php           # Daftar anggota
│   │       ├── create.blade.php          # Form tambah anggota
│   │       ├── edit.blade.php            # Form edit anggota
│   │       └── show.blade.php            # Profil anggota
│   └── css/
│       └── app.css                       # Tailwind CSS
├── routes/
│   └── web.php                           # Route definitions
├── storage/
│   └── app/
│       └── public/
│           ├── logos/                    # Upload folder untuk logo UKM
│           └── avatars/                  # Upload folder untuk foto anggota
└── public/
    └── storage/                          # Symlink ke storage/app/public
```

## 🎯 Routes

### UKM Management
```
GET    /ukm                    # Daftar UKM
GET    /ukm/create             # Form tambah UKM
POST   /ukm                    # Simpan UKM baru
GET    /ukm/{ukm}              # Detail UKM + Org Chart
GET    /ukm/{ukm}/edit         # Form edit UKM
PUT    /ukm/{ukm}              # Update UKM
DELETE /ukm/{ukm}              # Hapus UKM
```

### User/Anggota Management
```
GET    /user                   # Daftar anggota
GET    /user/create            # Form tambah anggota
POST   /user                   # Simpan anggota baru
GET    /user/{user}            # Profil anggota
GET    /user/{user}/edit       # Form edit anggota
PUT    /user/{user}            # Update anggota
DELETE /user/{user}            # Hapus anggota
```

### Kepengurusan Management
```
POST   /ukm/{ukm}/kepengurusan              # Tambah anggota ke UKM
PUT    /kepengurusan/{kepengurusan}         # Update kepengurusan
DELETE /kepengurusan/{kepengurusan}         # Hapus kepengurusan
```

## 🎨 UI/UX Features

### Color Scheme
- **Primary**: Blue (`#0066CC`)
- **Success**: Green (`#10B981`)
- **Danger**: Red (`#EF4444`)
- **Secondary**: Purple, Pink untuk header

### Components
- ✅ Responsive grid layout
- 🔘 Modern buttons dengan hover effects
- 📊 Card-based design
- 🎯 Modal dialogs
- 📱 Mobile-friendly navigation
- ⚡ Smooth transitions & animations

### Tailwind CSS Classes
- Grid responsive: `grid-cols-1 md:grid-cols-2 lg:grid-cols-3`
- Shadows: `shadow-md hover:shadow-lg`
- Spacing: `p-6`, `px-4`, `py-2`
- Colors: `bg-blue-600`, `text-gray-900`
- Utilities: `rounded-lg`, `transition`

## 🧪 Testing

### Create New UKM
1. Klik "Tambah UKM"
2. Isi form dengan data UKM
3. Upload logo/foto
4. Klik "Simpan UKM"

### Add Member to UKM
1. Buka detail UKM
2. Klik "Tambah Anggota"
3. Pilih user dan jabatan
4. Klik "Tambah"

### Create New User
1. Klik "Tambah Anggota"
2. Isi form dengan data user
3. Upload foto profil
4. Klik "Simpan Anggota"

## 💾 File Upload Configuration

Upload files disimpan di:
- **Logo UKM**: `storage/app/public/logos/`
- **Foto Anggota**: `storage/app/public/avatars/`

Di-access via: `asset('storage/logos/filename.jpg')`

Max size: **2MB** per file

## 🔐 Validation Rules

### UKM
- `nama`: required, unique, max 100 chars
- `bidang`: required, max 50 chars
- `logo`: image, max 2MB (jpeg, png, jpg, gif)
- `email`: nullable, email format
- `status`: required, in (aktif, nonaktif)

### User
- `name`: required, max 100 chars
- `email`: required, unique, email format
- `password`: required, min 6 chars, confirmed
- `photo`: image, max 2MB (jpeg, png, jpg, gif)

### Kepengurusan
- `user_id`: required, exists in users
- `jabatan_id`: required, exists in jabatans
- `tanggal_mulai`: nullable, date format

## 📊 Dummy Data

Seeder membuat:
- **15 Users** dengan data random (factory)
- **7 Jabatan**: Ketua Umum, Wakil Ketua, Sekretaris Umum, Bendahara, Kepala Divisi, Sekretaris Divisi, Anggota
- **5 UKM**: Teknik, Olahraga Basket, Bisnis, Seni Budaya, Fotografi
- **Kepengurusan**: Relasi antara UKM, User, dan Jabatan

## 🛠️ Development Tips

### Add Validation
```php
$validated = $request->validate([
    'field' => 'required|max:100',
]);
```

### Query dengan Relations
```php
$ukm = Ukm::with('kepengurusans.user', 'kepengurusans.jabatan')->find($id);
```

### Upload File
```php
if ($request->hasFile('logo')) {
    $path = $request->file('logo')->store('logos', 'public');
}
```

## 🚨 Troubleshooting

### Storage link tidak berfungsi
```bash
php artisan storage:link
```

### Database belum ter-migrate
```bash
php artisan migrate
php artisan db:seed
```

### File tidak terlihat di browser
Pastikan symlink sudah dibuat:
```bash
ls public/storage
```

## 📝 License

Created with ❤️ for UKM Management System 2026

## 👥 Support

Untuk bantuan atau pertanyaan, silakan hubungi admin sistem.

---

**Last Updated**: July 22, 2026
**Version**: 1.0.0

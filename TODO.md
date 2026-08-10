# TODO - Redesign Struktur Organisasi UKM

## Steps
- [x] 1. Migration baru: tambah status `keluar` ke kepengurusans & keanggotaans
- [x] 2. KepengurusanController: divisiJabatanNames, validateDivisiJabatan, autoDemote, keluar
- [x] 3. UserController: updateJabatan auto-demote + toggleStatus redirect from org chart
- [x] 4. routes/web.php: tambah route kepengurusan.keluar
- [x] 5. UkmController@show: exclude status keluar dari $anggota
- [x] 6. ukm/show.blade.php: susun ulang org chart (Ketua→Wakil→Sek+Bend→grid Kepala Divisi)
- [x] 7. _org-card.blade.php: lingkaran avatar + klik langsung edit
- [x] 8. _org-empty-card.blade.php: siluet SVG abu-abu + klik buka modal
- [x] 9. DummyDataSeeder: 30 anggota (1 Ketua, 1 Wakil, 1 Sek, 1 Bend, 4 KaDiv, 4 SekDiv, 18 Anggota)
- [x] 10. Verifikasi: php artisan migrate:fresh --seed

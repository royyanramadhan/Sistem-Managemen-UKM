<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Kepengurusan;
use App\Models\Ukm;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Keanggotaan;
use Illuminate\Http\Request;

class KepengurusanController extends Controller
{
    /**
     * Jabatan inti yang hanya boleh ditempati satu orang dalam satu UKM.
     */
    protected function coreJabatanNames(): array
    {
        return ['Ketua Umum', 'Wakil Ketua', 'Sekretaris Umum', 'Bendahara'];
    }

    /**
     * Jabatan divisi yang hanya boleh ditempati satu orang per (ukm, divisi).
     */
    protected function divisiJabatanNames(): array
    {
        return ['Kepala Divisi', 'Sekretaris Divisi'];
    }

    /**
     * Cari pemegang aktif lain dari sebuah jabatan inti dalam satu UKM.
     * Mengembalikan record Kepengurusan pemegang lama (atau null).
     */
    protected function findCoreJabatanHolder(Ukm $ukm, int $jabatanId, int $excludeKepengurusanId = 0): ?Kepengurusan
    {
        $jabatan = Jabatan::find($jabatanId);
        if (!$jabatan || !in_array($jabatan->nama, $this->coreJabatanNames())) {
            return null;
        }

        $query = Kepengurusan::where('ukm_id', $ukm->id)
            ->where('jabatan_id', $jabatanId)
            ->where('status', 'aktif');

        if ($excludeKepengurusanId) {
            $query->where('id', '!=', $excludeKepengurusanId);
        }

        return $query->with('user')->first();
    }

    /**
     * Cari pemegang aktif lain dari jabatan divisi (Kepala/ Sekretaris Divisi)
     * dalam kombinasi (ukm_id, divisi_id, jabatan_id) yang sama.
     */
    protected function findDivisiJabatanHolder(Ukm $ukm, int $jabatanId, int $divisiId, int $excludeKepengurusanId = 0): ?Kepengurusan
    {
        $jabatan = Jabatan::find($jabatanId);
        if (!$jabatan || !in_array($jabatan->nama, $this->divisiJabatanNames()) || !$divisiId) {
            return null;
        }

        $query = Kepengurusan::where('ukm_id', $ukm->id)
            ->where('jabatan_id', $jabatanId)
            ->where('divisi_id', $divisiId)
            ->where('status', 'aktif');

        if ($excludeKepengurusanId) {
            $query->where('id', '!=', $excludeKepengurusanId);
        }

        return $query->with('user')->first();
    }

    /**
     * Otomatis turunkan pemegang lama menjadi "Anggota" (tetap di divisi lamanya,
     * atau tanpa divisi jika tidak punya). Mengembalikan pesan notifikasi.
     */
    protected function demoteToAnggota(Kepengurusan $holder, Ukm $ukm): string
    {
        $oldName = $holder->user->name ?? 'Pengguna';
        $oldJabatanNama = $holder->jabatan->nama ?? 'Jabatan';

        $jabatanAnggota = Jabatan::where('nama', 'Anggota')->first();
        if ($jabatanAnggota) {
            $holder->update([
                'jabatan_id' => $jabatanAnggota->id,
                // Pertahankan divisi lama (jabatan Anggota memang boleh berdivisi)
                'divisi_id' => $holder->divisi_id,
                'status' => 'aktif',
            ]);
        }

        return "{$oldName} ({$oldJabatanNama}) otomatis diturunkan menjadi Anggota.";
    }

    /**
     * Otomatis menurunkan pemegang lama jabatan (inti atau kepala/sekretaris divisi)
     * sebelum seseorang ditempatkan pada jabatan tersebut.
     *
     * Mengembalikan pesan notifikasi tambahan (atau null jika tidak ada siapa pun yang diturunkan).
     */
    protected function autoDemoteExistingHolder(Ukm $ukm, int $jabatanId, int $divisiId, int $excludeKepengurusanId = 0): ?string
    {
        $holder = null;

        // Cek jabatan inti UKM
        $holder = $this->findCoreJabatanHolder($ukm, $jabatanId, $excludeKepengurusanId);

        // Kalau bukan jabatan inti, cek jabatan divisi (Kepala/ Sekretaris Divisi)
        if (!$holder) {
            $holder = $this->findDivisiJabatanHolder($ukm, $jabatanId, $divisiId, $excludeKepengurusanId);
        }

        if ($holder) {
            return $this->demoteToAnggota($holder, $ukm);
        }

        return null;
    }

    public function store(Request $request, Ukm $ukm)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date',
            'replace_existing' => 'nullable|boolean',
            'edit_kepengurusan_id' => 'nullable|exists:kepengurusans,id',
            'slot_jabatan_id' => 'nullable|exists:jabatans,id',
            'slot_divisi_id' => 'nullable|exists:divisis,id',
        ]);

        $validated['ukm_id'] = $ukm->id;
        $validated['divisi_id'] = $validated['divisi_id'] ?? null;

        // ===== Gunakan jabatan/divisi awal dari hidden slot jika disediakan =====
        $editKepengurusanId = $validated['edit_kepengurusan_id'] ?? null;
        $slotJabatanId = $validated['slot_jabatan_id'] ?? null;
        $slotDivisiId = $validated['slot_divisi_id'] ?? null;

        // ===== Validasi server-side: pastikan user adalah anggota yang disetujui (diterima) di UKM ini =====
        $isMember = Keanggotaan::where('ukm_id', $ukm->id)
            ->where('user_id', $validated['user_id'])
            ->where('status', 'diterima')
            ->exists();

        if (!$isMember) {
            return redirect()->route('ukm.show', $ukm)
                ->with('error', 'Pengguna yang dipilih bukan anggota yang disetujui di UKM ini.');
        }

        // Kalau datang dari slot (isi slot kosong), kunci jabatan/divisi sesuai slot
        if ($slotJabatanId) {
            $validated['jabatan_id'] = $slotJabatanId;
        }
        if ($slotDivisiId) {
            $validated['divisi_id'] = $slotDivisiId;
        }

        // ===== Validasi: divisi yang dipilih harus milik UKM yang sama =====
        if (!empty($validated['divisi_id'])) {
            $divisi = Divisi::find($validated['divisi_id']);
            if (!$divisi || $divisi->ukm_id !== $ukm->id) {
                return redirect()->route('ukm.show', $ukm)
                    ->with('error', 'Divisi yang dipilih tidak valid untuk UKM ini.');
            }
        }

        // ===== AUTO-DEMOTE pemegang lama jabatan (inti UKM / kepala divisi) =====
        // Jika jabatan sedang dipegang orang lain, pemegang lama otomatis turun ke Anggota.
        $demotedMessage = $this->autoDemoteExistingHolder(
            $ukm,
            (int) $validated['jabatan_id'],
            (int) ($validated['divisi_id'] ?? 0),
            $editKepengurusanId ? (int) $editKepengurusanId : 0
        );

        // ===== Kasus klik "ganti" pada slot yang sudah terisi =====
        // Jika datang dari slot dengan edit_kepengurusan_id, update record tsb.
        if ($editKepengurusanId) {
            $existing = Kepengurusan::find($editKepengurusanId);
            if ($existing && $existing->ukm_id === $ukm->id) {
                $existing->update([
                    'user_id' => $validated['user_id'],
                    'jabatan_id' => $validated['jabatan_id'],
                    'divisi_id' => $validated['divisi_id'] ?? $existing->divisi_id,
                    'tanggal_mulai' => $validated['tanggal_mulai'] ?? $existing->tanggal_mulai,
                    'tanggal_akhir' => $validated['tanggal_akhir'] ?? $existing->tanggal_akhir,
                    'status' => 'aktif',
                ]);

                return redirect()->route('ukm.show', $ukm)
                    ->with('success', 'Slot berhasil diperbarui. ' . ($demotedMessage ?? ''));
            }
        }

        // ===== Kasus biasa: user sudah punya jabatan aktif lain di UKM yang sama =====
        $existing = Kepengurusan::where('ukm_id', $ukm->id)
            ->where('user_id', $validated['user_id'])
            ->where('status', 'aktif')
            ->first();

        $replace = $request->boolean('replace_existing');

        if ($existing) {
            // Jika tidak ada konfirmasi "Ganti", tolak & beri tahu admin lewat session flag
            if (!$replace) {
                return redirect()->route('ukm.show', $ukm)
                    ->with('confirm_replace', [
                        'user_id' => $existing->user_id,
                        'user_name' => $existing->user->name ?? 'Pengguna',
                        'old_jabatan' => $existing->jabatan->nama ?? 'Jabatan Lama',
                        'new_jabatan' => Jabatan::find($validated['jabatan_id'])->nama ?? 'Jabatan Baru',
                        'jabatan_id' => $validated['jabatan_id'],
                        'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
                        'tanggal_akhir' => $validated['tanggal_akhir'] ?? null,
                    ])
                    ->with('error', 'Mahasiswa ini sudah memiliki jabatan aktif di UKM ini.');
            }

            // ===== Konfirmasi "Ganti": update row kepengurusan lama (bukan insert baru/dobel) =====
            $existing->update([
                'jabatan_id' => $validated['jabatan_id'],
                'divisi_id' => $validated['divisi_id'] ?? $existing->divisi_id,
                'tanggal_mulai' => $validated['tanggal_mulai'] ?? $existing->tanggal_mulai,
                'tanggal_akhir' => $validated['tanggal_akhir'] ?? $existing->tanggal_akhir,
            ]);

            return redirect()->route('ukm.show', $ukm)
                ->with('success', 'Jabatan pengurus berhasil diganti. ' . ($demotedMessage ?? ''));
        }

        // Tidak ada jabatan aktif sebelumnya → buat record baru
        Kepengurusan::create($validated);

        return redirect()->route('ukm.show', $ukm)
            ->with('success', 'Anggota berhasil ditambahkan! ' . ($demotedMessage ?? ''));
    }

    public function update(Request $request, Kepengurusan $kepengurusan)
    {
        $ukm = $kepengurusan->ukm;

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['divisi_id'] = $validated['divisi_id'] ?? null;

        // ===== Validasi: divisi yang dipilih harus milik UKM yang sama =====
        if (!empty($validated['divisi_id'])) {
            $divisi = Divisi::find($validated['divisi_id']);
            if (!$divisi || $divisi->ukm_id !== $ukm->id) {
                return redirect()->route('ukm.show', $ukm)
                    ->with('error', 'Divisi yang dipilih tidak valid untuk UKM ini.');
            }
        }

        // ===== AUTO-DEMOTE pemegang lama jabatan (kecuali record ini sendiri) =====
        $demotedMessage = $this->autoDemoteExistingHolder(
            $ukm,
            (int) $validated['jabatan_id'],
            (int) ($validated['divisi_id'] ?? $kepengurusan->divisi_id ?? 0),
            $kepengurusan->id
        );

        $kepengurusan->update($validated);

        return redirect()->route('ukm.show', $ukm)
            ->with('success', 'Data kepengurusan berhasil diperbarui. ' . ($demotedMessage ?? ''));
    }

    /**
     * Aksi "Keluar dari UKM": set status kepengurusan & keanggotaan terkait menjadi 'keluar'.
     * Beda dari nonaktif: dianggap final, anggota tidak muncul di dropdown "Pilih Anggota",
     * dan slot jabatan (jika ia pemegang jabatan inti/kepala divisi) otomatis kosong lagi.
     */
    public function keluar(Kepengurusan $kepengurusan)
    {
        $ukm = $kepengurusan->ukm;

        $kepengurusan->update(['status' => 'keluar']);

        // Set keanggotaan terkait (user + ukm) menjadi 'keluar'
        Keanggotaan::where('user_id', $kepengurusan->user_id)
            ->where('ukm_id', $ukm->id)
            ->update(['status' => 'keluar']);

        return redirect()->route('ukm.show', $ukm)
            ->with('success', 'Anggota berhasil dikeluarkan dari UKM.');
    }

    public function destroy(Kepengurusan $kepengurusan)
    {
        $ukm = $kepengurusan->ukm;
        $kepengurusan->delete();

        return redirect()->route('ukm.show', $ukm)->with('success', 'Anggota berhasil dihapus!');
    }
}

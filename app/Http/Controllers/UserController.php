<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Kepengurusan;
use App\Models\Keanggotaan;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Halaman Data Anggota.
     * Anggota berasal dari data kepengurusan yang dibuat otomatis
     * saat pendaftaran UKM disetujui oleh admin (status keanggotaan = diterima).
     */
    public function index(Request $request)
    {
        $query = Kepengurusan::with(['user', 'ukm', 'jabatan']);

        // Filter Status (default 'aktif' jika tidak ada filter status khusus)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'aktif');
        }

        // Pencarian berdasarkan Nama atau NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter UKM
        if ($request->filled('ukm')) {
            $query->where('ukm_id', $request->ukm);
        }

        // Filter Jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan_id', $request->jabatan);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->orderBy('created_at', 'desc')->get();

        $ukms = Ukm::orderBy('nama')->get();
        $jabatans = Jabatan::orderBy('level')->get();

        return view('user.index', compact('members', 'ukms', 'jabatans'));
    }

    /**
     * Detail anggota (berdasarkan record kepengurusan).
     */
    public function show(Kepengurusan $kepengurusan)
    {
        $kepengurusan->load(['user', 'ukm', 'jabatan']);

        // Data pendaftaran terkait (untuk tanggal daftar, tanggal diterima, KTM, dll)
        $keanggotaan = Keanggotaan::where('user_id', $kepengurusan->user_id)
            ->where('ukm_id', $kepengurusan->ukm_id)
            ->first();

        return view('user.show', compact('kepengurusan', 'keanggotaan'));
    }

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
     * Cari pemegang aktif lain dari jabatan (inti UKM / kepala-sekretaris divisi).
     * Mengembalikan record Kepengurusan pemegang lama (atau null).
     */
    protected function findHolder(Kepengurusan $kepengurusan, int $jabatanId, int $divisiId): ?Kepengurusan
    {
        $jabatan = Jabatan::find($jabatanId);
        if (!$jabatan) {
            return null;
        }

        $query = Kepengurusan::where('ukm_id', $kepengurusan->ukm_id)
            ->where('jabatan_id', $jabatanId)
            ->where('status', 'aktif')
            ->where('id', '!=', $kepengurusan->id);

        if (in_array($jabatan->nama, $this->coreJabatanNames())) {
            // Jabatan inti: unik per UKM (tidak filter divisi)
        } elseif (in_array($jabatan->nama, $this->divisiJabatanNames()) && $divisiId) {
            // Jabatan divisi: unik per (ukm, divisi)
            $query->where('divisi_id', $divisiId);
        } else {
            return null;
        }

        return $query->with('user')->first();
    }

    /**
     * Otomatis turunkan pemegang lama menjadi "Anggota".
     */
    protected function demoteToAnggota(Kepengurusan $holder): string
    {
        $oldName = $holder->user->name ?? 'Pengguna';
        $oldJabatanNama = $holder->jabatan->nama ?? 'Jabatan';

        $jabatanAnggota = Jabatan::where('nama', 'Anggota')->first();
        if ($jabatanAnggota) {
            $holder->update([
                'jabatan_id' => $jabatanAnggota->id,
                'divisi_id' => $holder->divisi_id,
                'status' => 'aktif',
            ]);
        }

        return "{$oldName} ({$oldJabatanNama}) otomatis diturunkan menjadi Anggota.";
    }

    /**
     * Ubah jabatan anggota (pada record kepengurusan).
     */
    public function updateJabatan(Request $request, Kepengurusan $kepengurusan)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'nullable|exists:divisis,id',
        ]);

        $ukm = $kepengurusan->ukm;

        $jabatanId = (int) $request->jabatan_id;
        $divisiId = (int) ($request->divisi_id ?? $kepengurusan->divisi_id ?? 0);

        // ===== AUTO-DEMOTE pemegang lama jabatan (inti UKM / kepala divisi) =====
        $demoteMessage = null;
        $holder = $this->findHolder($kepengurusan, $jabatanId, $divisiId);
        if ($holder) {
            $demoteMessage = $this->demoteToAnggota($holder);
        }

        $kepengurusan->update([
            'jabatan_id' => $jabatanId,
            'divisi_id' => $request->divisi_id ?? $kepengurusan->divisi_id,
        ]);

        return redirect()->route('ukm.show', $ukm)
            ->with('success', 'Jabatan anggota berhasil diperbarui. ' . ($demoteMessage ?? ''));
    }

    /**
     * Ubah status anggota (Aktif/Nonaktif) tanpa menghapus data.
     * Bisa dipanggil dari halaman daftar anggota (user.index) maupun dari org chart (ukm.show).
     */
    public function toggleStatus(Request $request, Kepengurusan $kepengurusan)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $kepengurusan->update([
            'status' => $request->status,
        ]);

        // Jika request berasal dari org chart (ukm.show), redirect balik ke sana.
        if ($request->has('redirect') && $request->redirect === 'ukm.show') {
            return redirect()->route('ukm.show', $kepengurusan->ukm)
                ->with('success', 'Status anggota berhasil diperbarui.');
        }

        return redirect()->route('user.index')
            ->with('success', 'Status anggota berhasil diperbarui.');
    }

    // ============================================================
    // Metode di bawah ini TIDAK dipakai lagi (arsip).
    // Anggota tidak boleh ditambah/diubah data pribadinya secara manual.
    // Data anggota sepenuhnya berasal dari pendaftaran UKM yang disetujui.
    // ============================================================

    public function create()
    {
        return redirect()->route('user.index')->with('error', 'Anggota tidak dapat ditambahkan secara manual. Data anggota berasal dari pendaftaran UKM yang disetujui.');
    }

    public function store(Request $request)
    {
        return redirect()->route('user.index')->with('error', 'Anggota tidak dapat ditambahkan secara manual. Data anggota berasal dari pendaftaran UKM yang disetujui.');
    }

    public function edit(User $user)
    {
        return redirect()->route('user.index')->with('error', 'Data pribadi anggota tidak dapat diubah oleh admin.');
    }

    public function update(Request $request, User $user)
    {
        return redirect()->route('user.index')->with('error', 'Data pribadi anggota tidak dapat diubah oleh admin.');
    }

    public function destroy(User $user)
    {
        return redirect()->route('user.index')->with('error', 'Anggota tidak dapat dihapus. Ubah status menjadi Nonaktif untuk menonaktifkan.');
    }
}

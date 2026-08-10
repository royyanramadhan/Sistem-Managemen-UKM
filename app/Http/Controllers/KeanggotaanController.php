<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Keanggotaan;
use App\Models\Ukm;
use App\Models\Jabatan;
use App\Models\Kepengurusan;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeanggotaanController extends Controller
{
    /**
     * Hitung state pendaftaran user yang sedang login.
     * Digunakan untuk validasi frontend & backend agar konsisten.
     */
    protected function getRegistrationState()
    {
        $user = auth()->user();

        $registrations = $user->keanggotaans()->with('ukm')->get();

        $pending = $registrations->firstWhere('status', 'pending');
        $accepted = $registrations->firstWhere('status', 'diterima');

        return [
            'hasPending' => !is_null($pending),
            'hasAccepted' => !is_null($accepted),
            'pendingRegistration' => $pending,
            'acceptedRegistration' => $accepted,
            'rejectedUkmIds' => $registrations
                ->where('status', 'ditolak')
                ->pluck('ukm_id')
                ->all(),
            'acceptedUkmIds' => $registrations
                ->where('status', 'diterima')
                ->pluck('ukm_id')
                ->all(),
        ];
    }

    // Halaman daftar UKM (untuk memilih UKM yang ingin didaftar)
    public function index()
    {
        $ukms = Ukm::withCount('keanggotaans')
            ->where('status', 'aktif')
            ->get();

        $myRegistrations = auth()->check()
            ? auth()->user()->keanggotaans()->with('ukm')->get()
            : collect();

        $state = auth()->check() ? $this->getRegistrationState() : null;

        return view('public.daftar', compact('ukms', 'myRegistrations', 'state'));
    }

    // Halaman form pendaftaran per UKM
    public function create(Ukm $ukm)
    {
        abort_unless($ukm->status === 'aktif', 404);

        $state = $this->getRegistrationState();

        // Blokir jika masih ada pendaftaran pending
        if ($state['hasPending']) {
            return redirect()->route('daftar.index')
                ->with('error', 'Anda masih memiliki pendaftaran yang sedang diproses. Silakan tunggu hasil verifikasi admin.');
        }

        // Blokir jika sudah diterima di salah satu UKM
        if ($state['hasAccepted']) {
            return redirect()->route('daftar.index')
                ->with('error', 'Anda sudah menjadi anggota UKM, sehingga tidak dapat mendaftar ke UKM lain.');
        }

        // Blokir jika pernah ditolak pada UKM ini
        if (in_array($ukm->id, $state['rejectedUkmIds'])) {
            return redirect()->route('daftar.index')
                ->with('error', 'Permohonan Anda untuk UKM ' . $ukm->nama . ' telah ditolak. Anda tidak dapat mendaftar kembali ke UKM tersebut.');
        }

        // Cek apakah sudah pernah mendaftar (safety, mencegah duplikat)
        $existing = auth()->user()->keanggotaans()->where('ukm_id', $ukm->id)->first();

        return view('public.daftar-create', compact('ukm', 'existing', 'state'));
    }

    // Halaman status pendaftaran user
    public function statusPendaftaran()
    {
        $registrations = auth()->user()->keanggotaans()->with('ukm')->latest()->get();

        return view('public.status', compact('registrations'));
    }

    // Kirim permohonan daftar online (status pending)
    public function store(Request $request)
    {
        $request->validate([
            'ukm_id' => 'required|exists:ukms,id',
            'no_hp' => 'required|string|max:20',
            'fakultas' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:4',
            'alasan' => 'required|string',
            'ktm' => 'nullable|image|mimes:jpg,jpeg|max:3072',
        ]);

        $ukm = Ukm::findOrFail($request->ukm_id);

        $state = $this->getRegistrationState();

        // ===== Validasi backend (anti manipulasi URL / request langsung) =====

        // 1. Blokir jika masih ada pendaftaran pending
        if ($state['hasPending']) {
            return redirect()->route('daftar.index')
                ->with('error', 'Anda masih memiliki pendaftaran yang sedang diproses. Silakan tunggu hasil verifikasi admin.');
        }

        // 2. Blokir jika sudah diterima di salah satu UKM
        if ($state['hasAccepted']) {
            return redirect()->route('daftar.index')
                ->with('error', 'Anda sudah menjadi anggota UKM, sehingga tidak dapat mendaftar ke UKM lain.');
        }

        // 3. Blokir jika pernah ditolak pada UKM ini
        if (in_array($ukm->id, $state['rejectedUkmIds'])) {
            return back()->with('error', 'Permohonan Anda untuk UKM ' . $ukm->nama . ' telah ditolak. Anda tidak dapat mendaftar kembali ke UKM tersebut.');
        }

        // 4. Cegah duplikat (double-click / refresh setelah submit)
        //    Periksa keberadaan record apa pun (pending/diterima/ditolak) untuk user+ukm ini.
        $exists = Keanggotaan::where('user_id', auth()->id())
            ->where('ukm_id', $ukm->id)
            ->first();

        if ($exists) {
            if ($exists->status === 'pending') {
                return redirect()->route('pendaftaran.status')
                    ->with('error', 'Permohonan Anda untuk UKM ini sedang menunggu persetujuan.');
            }
            if ($exists->status === 'diterima') {
                return redirect()->route('pendaftaran.status')
                    ->with('error', 'Anda sudah terdaftar sebagai anggota UKM ini.');
            }
            // Ditolak: tidak boleh daftar ulang ke UKM yang sama
            return back()->with('error', 'Permohonan Anda untuk UKM ini telah ditolak dan tidak dapat diajukan ulang.');
        }

        $keanggotaan = Keanggotaan::create([
            'user_id' => auth()->id(),
            'ukm_id' => $ukm->id,
            'tanggal_daftar' => now(),
            'status' => 'pending',
            'no_hp' => $request->no_hp,
            'fakultas' => $request->fakultas,
            'program_studi' => $request->program_studi,
            'angkatan' => $request->angkatan,
            'alasan' => $request->alasan,
            'ktm' => $request->hasFile('ktm') ? $request->file('ktm')->store('ktm', 'public') : null,
        ]);

        // Notifikasi admin
        $this->notifyAdmin($keanggotaan);

        if (!empty($ukm->link_pendaftaran) && filter_var($ukm->link_pendaftaran, FILTER_VALIDATE_URL)) {
            session()->flash('success', 'Pendaftaran awal berhasil! Anda akan diarahkan ke formulir Google UKM untuk melanjutkan proses pendaftaran.');
            return redirect()->away($ukm->link_pendaftaran);
        }

        return redirect()->route('pendaftaran.status')
            ->with('error', 'Pendaftaran awal berhasil, tetapi formulir Google UKM belum tersedia. Silakan hubungi admin UKM untuk informasi lebih lanjut.');
    }

    // Kirim notifikasi ke semua admin
    protected function notifyAdmin($keanggotaan)
    {
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewRegistrationNotification($keanggotaan));
        }
    }

    // Halaman persetujuan admin
    public function adminIndex()
    {
        $pending = Keanggotaan::with(['user', 'ukm'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $approved = Keanggotaan::with(['user', 'ukm'])
            ->where('status', 'diterima')
            ->orderBy('created_at', 'desc')
            ->get();

        $rejected = Keanggotaan::with(['user', 'ukm'])
            ->where('status', 'ditolak')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.keanggotaan', compact('pending', 'approved', 'rejected'));
    }

    // Terima permohonan
    public function approve(Keanggotaan $keanggotaan)
    {
        // Cek apakah user sudah diterima di UKM lain
        $alreadyAccepted = Keanggotaan::where('user_id', $keanggotaan->user_id)
            ->where('status', 'diterima')
            ->where('id', '!=', $keanggotaan->id)
            ->exists();

        if ($alreadyAccepted) {
            return redirect()->route('admin.keanggotaan')
                ->with('error', 'Pengguna ini sudah menjadi anggota di UKM lain.');
        }

        $keanggotaan->update(['status' => 'diterima']);

        // Otomatis batalkan / tolak permohonan pending lainnya dari user ini
        Keanggotaan::where('user_id', $keanggotaan->user_id)
            ->where('id', '!=', $keanggotaan->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'ditolak',
                'alasan_penolakan' => 'Permohonan dibatalkan otomatis karena pengguna telah diterima di UKM ' . ($keanggotaan->ukm->nama ?? 'lain') . '.',
            ]);

// Otomatis buat kepengurusan sebagai Anggota
        $jabatan = Jabatan::where('nama', 'Anggota')->first();
        if ($jabatan) {
            $existsKepengurusan = Kepengurusan::where('ukm_id', $keanggotaan->ukm_id)
                ->where('user_id', $keanggotaan->user_id)
                ->first();
if (!$existsKepengurusan) {
                // Anggota baru ditempatkan pada divisi pertama (default) milik UKM tsb.
                $defaultDivisi = Divisi::where('ukm_id', $keanggotaan->ukm_id)
                    ->where('status', 'aktif')
                    ->orderBy('id')
                    ->first();

                Kepengurusan::create([
                    'ukm_id' => $keanggotaan->ukm_id,
                    'user_id' => $keanggotaan->user_id,
                    'jabatan_id' => $jabatan->id,
                    'divisi_id' => $defaultDivisi?->id,
                    'tanggal_mulai' => now(),
                    'status' => 'aktif',
                ]);
            }
        }

        return redirect()->route('admin.keanggotaan')->with('success', 'Permohonan disetujui. Anggota berhasil ditambahkan.');
    }

    // Tolak permohonan
    public function reject(Request $request, Keanggotaan $keanggotaan)
    {
        $request->validate([
            'alasan_penolakan' => 'nullable|string|max:1000',
        ]);

        $keanggotaan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('admin.keanggotaan')->with('success', 'Permohonan ditolak.');
    }

    // Halaman profil user
    public function showProfile()
    {
        $user = auth()->user();
        return view('public.profil', compact('user'));
    }

    // Update profil user
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'fakultas' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:4',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (array_key_exists('no_hp', $data)) {
            $data['telepon'] = $data['no_hp'];
            unset($data['no_hp']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}

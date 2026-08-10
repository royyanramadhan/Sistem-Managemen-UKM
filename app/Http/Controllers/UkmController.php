<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Ukm;
use App\Models\Jabatan;
use App\Models\Kepengurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UkmController extends Controller
{
    public function index()
    {
        $ukms = Ukm::withCount(['kepengurusans', 'prestasis', 'kegiatans'])->get();
        return view('ukm.index', compact('ukms'));
    }

    public function create()
    {
        return view('ukm.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ukms',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang' => 'required|string|max:50',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'link_pendaftaran' => 'nullable|url',
        ]);

        // Handle logo upload with error handling
        if ($request->hasFile('logo')) {
            try {
                $path = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $path;
            } catch (\Exception $e) {
                \Log::error("Logo upload failed during creation: " . $e->getMessage());
                return back()->withErrors(['logo' => 'Gagal mengunggah logo. Silakan coba lagi.']);
            }
        }
        Ukm::create($validated);

        return redirect()->route('ukm.index')->with('success', 'UKM berhasil dibuat!');
    }

    public function show(Ukm $ukm)
    {
        // Load semua relasi yang dibutuhkan: Kepengurusan, User, Jabatan, Prestasi, dan Kegiatan
$ukm->load([
            'kepengurusans.user',
            'kepengurusans.jabatan',
            'kepengurusans.divisi',
            'divisis',
            'prestasis',
            'kegiatans',
        ]);

// Divisi milik UKM ini (bukan global) untuk struktur organisasi
        $divisis = $ukm->divisis()->where('status', 'aktif')->orderBy('id')->get();

        // Ambil data jabatan untuk dropdown di Modal Tambah Anggota
        $jabatans = Jabatan::all();

// ===== Anggota yang disetujui (status diterima) di UKM ini → untuk Daftar Anggota + dropdown searchable =====
        // Gunakan whereHas('user') untuk memastikan hanya memuat record yang punya relasi User valid,
        // sehingga item di collection SELALU bertipe Keanggotaan Model (bukan boolean/null).
        // Exclude anggota dengan status 'keluar' agar tidak muncul di dropdown "Pilih Anggota".
        $anggota = $ukm->keanggotaans()
            ->with('user')
            ->whereHas('user')
            ->where('status', 'diterima')
            ->where('status', '!=', 'keluar')
            ->orderBy('created_at', 'desc')
            ->get();

        // Peta pengurus aktif: user_id => nama jabatan (cek dobel jabatan client-side).
        // ->all() agar @json menghasilkan objek/array asosiatif bersih, bukan Collection.
        $pengurusAktif = Kepengurusan::where('ukm_id', $ukm->id)
            ->where('status', 'aktif')
            ->with('jabatan')
            ->get()
            ->mapWithKeys(fn($k) => [$k->user_id => $k->jabatan->nama])
            ->all();

        return view('ukm.show', compact('ukm', 'jabatans', 'anggota', 'pengurusAktif', 'divisis'));
    }

    public function edit(Ukm $ukm)
    {
        return view('ukm.edit', compact('ukm'));
    }

    public function update(Request $request, Ukm $ukm)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:ukms,nama,' . $ukm->id,
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang' => 'required|string|max:50',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'link_pendaftaran' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            try {
                // Delete old logo if it exists
                if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
                    Storage::disk('public')->delete($ukm->logo);
                }
                // Store new logo
                $path = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $path;
            } catch (\Exception $e) {
                \Log::error("Logo upload failed for UKM ID {$ukm->id}: " . $e->getMessage());
                return back()->withErrors(['logo' => 'Gagal mengunggah logo. Silakan coba lagi.']);
            }
        }

        $ukm->update($validated);

        return redirect()->route('ukm.show', $ukm)->with('success', 'UKM berhasil diperbarui!');
    }

    public function destroy(Ukm $ukm)
    {
        if ($ukm->logo && Storage::disk('public')->exists($ukm->logo)) {
            Storage::disk('public')->delete($ukm->logo);
        }

        $ukm->kepengurusans()->delete();
        $ukm->delete();

        return redirect()->route('ukm.index')->with('success', 'UKM berhasil dihapus!');
    }
}
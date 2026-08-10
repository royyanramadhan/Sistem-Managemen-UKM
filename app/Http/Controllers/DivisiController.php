<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Kepengurusan;
use App\Models\Ukm;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Simpan divisi baru milik UKM tertentu.
     */
    public function store(Request $request, Ukm $ukm)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:divisis,nama,NULL,id,ukm_id,' . $ukm->id,
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        Divisi::create([
            'ukm_id' => $ukm->id,
            'nama' => $validated['nama'],
            'status' => $validated['status'] ?? 'aktif',
        ]);

        return redirect()->route('ukm.show', $ukm)->with('success', 'Divisi berhasil ditambahkan.');
    }

    /**
     * Perbarui divisi milik UKM tertentu.
     */
    public function update(Request $request, Ukm $ukm, Divisi $divisi)
    {
        // Pastikan divisi benar-benar milik UKM ini.
        abort_unless($divisi->ukm_id === $ukm->id, 403);

        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:divisis,nama,' . $divisi->id . ',id,ukm_id,' . $ukm->id,
            'status' => 'nullable|in:aktif,nonaktif',
        ]);

        $divisi->update([
            'nama' => $validated['nama'],
            'status' => $validated['status'] ?? 'aktif',
        ]);

        // Nama divisi berubah → seluruh halaman yang memakai relasi divisi otomatis ikut berubah.
        return redirect()->route('ukm.show', $ukm)->with('success', 'Divisi berhasil diperbarui.');
    }

    /**
     * Hapus divisi milik UKM tertentu.
     */
    public function destroy(Ukm $ukm, Divisi $divisi)
    {
        // Pastikan divisi benar-benar milik UKM ini.
        abort_unless($divisi->ukm_id === $ukm->id, 403);

        // Kosongkan divisi pada kepengurusan agar data anggota tidak terhapus.
        Kepengurusan::where('ukm_id', $ukm->id)
            ->where('divisi_id', $divisi->id)
            ->update(['divisi_id' => null]);

        $divisi->delete();

        return redirect()->route('ukm.show', $ukm)->with('success', 'Divisi berhasil dihapus.');
    }
}

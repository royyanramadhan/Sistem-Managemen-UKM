<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // Halaman detail kegiatan (publik, tanpa login)
    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load('ukm');
        return view('kegiatan.show', compact('kegiatan'));
    }

// Menyimpan kegiatan baru dari Modal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ukm_id' => 'required|exists:ukms,id',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
        ]);

        Kegiatan::create([
            'ukm_id' => $validated['ukm_id'],
            'nama' => $validated['nama_kegiatan'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tempat' => $validated['lokasi'] ?? null,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => null,
            'jenis' => 'kegiatan',
            'status' => 'direncanakan',
        ]);

        return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    // Menghapus kegiatan
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}
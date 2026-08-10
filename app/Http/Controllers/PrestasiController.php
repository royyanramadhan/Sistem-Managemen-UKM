<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    // Daftar prestasi dengan pencarian & filter berdasarkan UKM
    public function index(Request $request)
    {
        $query = Prestasi::with(['ukm', 'user']);

        // Pencarian berdasarkan nama prestasi / deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_prestasi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan UKM
        if ($request->filled('ukm')) {
            $query->where('ukm_id', $request->ukm);
        }

        $prestasis = $query->latest()->get();

        $ukms = Ukm::orderBy('nama')->get();

        return view('prestasi.index', compact('prestasis', 'ukms'));
    }

    // Form tambah prestasi
    public function create()
    {
        $ukms = Ukm::orderBy('nama')->get();
        return view('prestasi.create', compact('ukms'));
    }

    // Simpan prestasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ukm_id' => 'required|exists:ukms,id',
            'user_id' => 'nullable|exists:users,id',
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|in:lokal,regional,nasional,internasional',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'piagam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('piagam')) {
            $validated['piagam'] = $request->file('piagam')->store('piagam', 'public');
        }

        Prestasi::create($validated);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil ditambahkan!');
    }

    // Detail prestasi (admin)
    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['ukm', 'user']);
        return view('prestasi.show', compact('prestasi'));
    }

    // Detail prestasi (publik, tanpa login)
    public function publicShow(Prestasi $prestasi)
    {
        $prestasi->load(['ukm', 'user']);
        return view('public.prestasi.show', compact('prestasi'));
    }

    // Form edit prestasi
    public function edit(Prestasi $prestasi)
    {
        $ukms = Ukm::orderBy('nama')->get();
        return view('prestasi.edit', compact('prestasi', 'ukms'));
    }

    // Update prestasi
    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'ukm_id' => 'required|exists:ukms,id',
            'user_id' => 'nullable|exists:users,id',
            'nama_prestasi' => 'required|string|max:255',
            'tingkat' => 'required|in:lokal,regional,nasional,internasional',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'piagam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('piagam')) {
            // Hapus piagam lama jika ada
            if ($prestasi->piagam && Storage::disk('public')->exists($prestasi->piagam)) {
                Storage::disk('public')->delete($prestasi->piagam);
            }
            $validated['piagam'] = $request->file('piagam')->store('piagam', 'public');
        }

        $prestasi->update($validated);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diperbarui!');
    }

    // Menghapus prestasi
    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->piagam && Storage::disk('public')->exists($prestasi->piagam)) {
            Storage::disk('public')->delete($prestasi->piagam);
        }

        $prestasi->delete();

        // Kembali ke halaman sebelumnya (detail UKM atau daftar prestasi)
        return redirect()->back()->with('success', 'Prestasi berhasil dihapus!');
    }
}


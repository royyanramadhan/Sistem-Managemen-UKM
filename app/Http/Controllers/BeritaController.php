<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // Daftar berita dengan pencarian & filter
    public function index(Request $request)
    {
        $query = Berita::with('ukm');

        // Pencarian berdasarkan judul
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%");
        }

        // Filter berdasarkan UKM
        if ($request->filled('ukm')) {
            $query->where('ukm_id', $request->ukm);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beritas = $query->latest('tanggal_publikasi')->get();
        $ukms = Ukm::orderBy('nama')->get();

        return view('berita.index', compact('beritas', 'ukms'));
    }

    // Form tambah berita
    public function create()
    {
        $ukms = Ukm::orderBy('nama')->get();
        return view('berita.create', compact('ukms'));
    }

    // Simpan berita baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ukm_id'             => 'nullable|exists:ukms,id',
            'judul'              => 'required|string|max:255',
            'isi'                => 'required|string',
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'kategori'           => 'nullable|string|max:100',
            'tanggal_publikasi'  => 'nullable|date',
            'status'             => 'required|in:draft,published',
            'tampil_di_dashboard' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);
        $validated['tampil_di_dashboard'] = $request->boolean('tampil_di_dashboard');

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    // Form edit berita
    public function edit(Berita $berita)
    {
        $ukms = Ukm::orderBy('nama')->get();
        return view('berita.edit', compact('berita', 'ukms'));
    }

    // Update berita
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'ukm_id'             => 'nullable|exists:ukms,id',
            'judul'              => 'required|string|max:255',
            'isi'                => 'required|string',
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'kategori'           => 'nullable|string|max:100',
            'tanggal_publikasi'  => 'nullable|date',
            'status'             => 'required|in:draft,published',
            'tampil_di_dashboard' => 'nullable|boolean',
        ]);

        $validated['tampil_di_dashboard'] = $request->boolean('tampil_di_dashboard');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Hapus berita
    public function destroy(Berita $berita)
    {
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }

    // Toggle tampil_di_dashboard (PATCH via AJAX / simple redirect)
    public function toggleDashboard(Berita $berita)
    {
        $berita->update([
            'tampil_di_dashboard' => !$berita->tampil_di_dashboard,
        ]);

        return redirect()->back()->with('success',
            $berita->tampil_di_dashboard
                ? 'Berita ditampilkan di dashboard user.'
                : 'Berita disembunyikan dari dashboard user.'
        );
    }
}

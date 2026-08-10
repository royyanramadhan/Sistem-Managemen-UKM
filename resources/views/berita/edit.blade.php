@extends('layouts.app')

@section('title', 'Edit Berita')

@section('breadcrumb', 'Edit Berita')

@section('content')
<div class="max-w-3xl space-y-6">
    <!-- Header -->
    <div class="card p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">✏️ Edit Berita</h1>
            <p class="text-slate-500 mt-1 text-sm">Perbarui informasi berita di bawah ini.</p>
        </div>
        <a href="{{ route('berita.index') }}" class="btn btn-outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card p-6">
        <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Judul Berita <span class="text-black">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" required placeholder="Masukkan judul berita..."
                    class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm @error('judul') border-red-500 @enderror">
                @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- UKM & Kategori -->
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">UKM Terkait</label>
                    <select name="ukm_id" class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm bg-white">
                        <option value="">— Umum / Tidak terkait UKM —</option>
                        @foreach($ukms as $ukm)
                            <option value="{{ $ukm->id }}" {{ old('ukm_id', $berita->ukm_id) == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                        @endforeach
                    </select>
                    @error('ukm_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm bg-white">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(['kegiatan','prestasi','pengumuman','agenda','organisasi'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $berita->kategori) == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Tanggal & Status -->
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Publikasi</label>
                    <input type="date" name="tanggal_publikasi"
                        value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm">
                    @error('tanggal_publikasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Status <span class="text-black">*</span></label>
                    <select name="status" class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm bg-white">
                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Gambar Berita</label>
                @if($berita->gambar)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-20 h-20 object-cover border border-black" alt="Gambar saat ini">
                        <span class="text-xs text-slate-500">Gambar saat ini. Upload baru untuk mengganti.</span>
                    </div>
                @endif
                <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="w-full px-4 py-2 border border-black focus:outline-none text-sm bg-white file:mr-4 file:py-1 file:px-4 file:border-0 file:border-r file:border-black file:bg-black file:text-white file:text-sm file:font-semibold hover:file:bg-slate-800">
                <p class="text-xs text-slate-400 mt-1">Format: JPEG, PNG, WebP. Maks: 3 MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Isi -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Berita <span class="text-black">*</span></label>
                <textarea name="isi" rows="8" required placeholder="Tulis isi berita di sini..."
                    class="w-full px-4 py-2.5 border border-black focus:outline-none text-sm resize-y @error('isi') border-red-500 @enderror">{{ old('isi', $berita->isi) }}</textarea>
                @error('isi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Tampil di Dashboard -->
            <div class="flex items-start gap-3 p-4 border border-black bg-slate-50">
                <input type="hidden" name="tampil_di_dashboard" value="0">
                <input type="checkbox" name="tampil_di_dashboard" id="tampil_di_dashboard" value="1"
                    {{ old('tampil_di_dashboard', $berita->tampil_di_dashboard) ? 'checked' : '' }}
                    class="mt-0.5 w-4 h-4 border border-black accent-black">
                <div>
                    <label for="tampil_di_dashboard" class="text-sm font-semibold text-slate-800 cursor-pointer">Tampilkan di Dashboard User</label>
                    <p class="text-xs text-slate-500 mt-0.5">Jika dicentang dan status <em>Published</em>, berita ini akan muncul di halaman utama website user.</p>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-black">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('berita.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

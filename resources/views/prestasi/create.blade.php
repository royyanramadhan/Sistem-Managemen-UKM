@extends('layouts.app')

@section('title', 'Tambah Prestasi')

@section('breadcrumb', 'Tambah Prestasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card p-6 md:p-8">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('prestasi.index') }}" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Prestasi</h1>
                <p class="text-sm text-slate-500">Catat pencapaian baru UKM.</p>
            </div>
        </div>

        <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">UKM <span class="text-red-500">*</span></label>
                <select name="ukm_id" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm bg-white" required>
                    <option value="">-- Pilih UKM --</option>
                    @foreach($ukms as $ukm)
                        <option value="{{ $ukm->id }}" {{ old('ukm_id') == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Prestasi <span class="text-red-500">*</span></label>
                <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}" placeholder="Contoh: Juara 1 Lomba Karya Ilmiah" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tingkat <span class="text-red-500">*</span></label>
                    <select name="tingkat" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm bg-white" required>
                        <option value="">-- Pilih Tingkat --</option>
                        @foreach(['lokal', 'regional', 'nasional', 'internasional'] as $lvl)
                            <option value="{{ $lvl }}" {{ old('tingkat') == $lvl ? 'selected' : '' }}>{{ ucfirst($lvl) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm" placeholder="Ceritakan prestasi yang diraih...">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Piagam / Bukti (Opsional, Gambar)</label>
                <input type="file" name="piagam" accept="image/*" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm bg-white">
                <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-amber flex-1">✅ Simpan Prestasi</button>
                <a href="{{ route('prestasi.index') }}" class="btn btn-ghost flex-1">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

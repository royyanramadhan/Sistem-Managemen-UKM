@extends('layouts.app')

@section('title', 'Edit UKM')
@section('breadcrumb', 'Edit UKM')

@section('content')
<div class="max-w-2xl mx-auto portal-card p-6 md:p-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#0F172A]">Edit UKM</h2>
        <p class="text-sm text-[#64748B] mt-1">Perbarui informasi unit kegiatan mahasiswa.</p>
    </div>
    <form action="{{ route('ukm.update', $ukm) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="portal-label" for="nama">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $ukm->nama) }}" required class="portal-input" placeholder="Contoh: UKM Olahraga" />
        </div>
        <div>
            <label class="portal-label" for="bidang">Bidang</label>
            <input type="text" name="bidang" id="bidang" value="{{ old('bidang', $ukm->bidang) }}" required class="portal-input" placeholder="Contoh: Olahraga" />
        </div>
        <div>
            <label class="portal-label" for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="portal-textarea" placeholder="Deskripsi singkat UKM">{{ old('deskripsi', $ukm->deskripsi) }}</textarea>
        </div>
        <div>
            <label class="portal-label" for="logo">Logo (opsional)</label>
            @if($ukm->logo)
                <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama }}" class="w-20 h-20 object-cover mb-2 border border-[#E2E8F0]">
            @endif
            <input type="file" name="logo" id="logo" class="w-full text-sm text-slate-500" />
        </div>
        <div>
            <label class="portal-label" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $ukm->email) }}" class="portal-input" placeholder="ukm@unimal.ac.id" />
        </div>
        <div>
            <label class="portal-label" for="telepon">Telepon</label>
            <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $ukm->telepon) }}" class="portal-input" placeholder="08xxxxxxxxxx" />
        </div>
        <div>
            <label class="portal-label" for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="2" class="portal-textarea" placeholder="Alamat sekretariat">{{ old('alamat', $ukm->alamat) }}</textarea>
        </div>
        <div>
            <label class="portal-label" for="status">Status</label>
            <select name="status" id="status" required class="portal-select">
                <option value="aktif" {{ old('status', $ukm->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $ukm->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div>
            <label class="portal-label" for="link_pendaftaran">Link Google Form (opsional)</label>
            <input type="url" name="link_pendaftaran" id="link_pendaftaran" value="{{ old('link_pendaftaran', $ukm->link_pendaftaran) }}" class="portal-input" placeholder="https://docs.google.com/forms/..." />
            <p class="text-xs text-slate-400 mt-1">Kosongkan untuk menghapus link Google Form (nilai akan menjadi null).</p>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="portal-btn portal-btn-primary">Update</button>
            <a href="{{ route('ukm.index') }}" class="portal-btn portal-btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
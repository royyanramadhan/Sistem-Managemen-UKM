@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('breadcrumb', 'Detail Anggota')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('user.index') }}" class="portal-btn portal-btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Data Anggota
        </a>
    </div>

    <!-- Profile Header -->
    <div class="portal-card overflow-hidden">
        <div class="bg-[#0B2D4A] h-32 relative">
            <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 1px, transparent 1px, transparent 12px);"></div>
        </div>
        <div class="px-6 md:px-8 pb-6">
            <div class="flex flex-col md:flex-row items-start md:items-end gap-6 -mt-14">
                <div class="flex-shrink-0">
                    @if($kepengurusan->user->photo)
                        <img src="{{ asset('storage/' . $kepengurusan->user->photo) }}" alt="{{ $kepengurusan->user->name }}" class="portal-profile-avatar">
                    @else
                        <div class="portal-profile-avatar flex items-center justify-center text-5xl bg-[#E8EEF4]">👤</div>
                    @endif
                </div>
                <div class="flex-grow pt-10">
                    <h1 class="text-2xl md:text-3xl font-bold text-[#0F172A]">{{ $kepengurusan->user->name }}</h1>
                    <p class="text-[#64748B] mt-1">NIM: {{ $kepengurusan->user->nim }}</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @php
                            $jabatanLabel = $kepengurusan->jabatan->nama;
                            if ($jabatanLabel === 'Kepala Divisi' && $kepengurusan->divisi) {
                                $jabatanLabel = 'Kepala Divisi ' . $kepengurusan->divisi->nama;
                            }
                        @endphp
                        <span class="portal-badge portal-badge-navy">{{ $kepengurusan->ukm->nama }}</span>
                        <span class="portal-badge portal-badge-green">{{ $jabatanLabel }}</span>
                        @include('partials._status-badge', ['status' => $kepengurusan->status])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Information -->
    <div class="portal-card p-6 md:p-8">
        <h2 class="text-xl font-bold text-[#0F172A] mb-6 border-b border-[#E2E8F0] pb-3">Informasi Anggota</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Data Pribadi -->
            <div class="border border-[#E2E8F0] p-5 bg-[#FAFBFC]">
                <h3 class="font-semibold text-[#475569] mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#0B2D4A]"></span> Data Pribadi
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Nama</span>
                        <span class="font-semibold text-[#0F172A]">{{ $kepengurusan->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">NIM</span>
                        <span class="font-semibold text-[#0F172A]">{{ $kepengurusan->user->nim }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Email</span>
                        <span class="font-semibold text-[#0F172A]">{{ $kepengurusan->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Nomor HP</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan->no_hp ?? $kepengurusan->user->telepon ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Fakultas</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan->fakultas ?? $kepengurusan->user->fakultas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Program Studi</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan->program_studi ?? $kepengurusan->user->program_studi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Angkatan</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan->angkatan ?? $kepengurusan->user->angkatan ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Data Keanggotaan -->
            <div class="border border-[#E2E8F0] p-5 bg-[#FAFBFC]">
                <h3 class="font-semibold text-[#475569] mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#1A4D3E]"></span> Data Keanggotaan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">UKM</span>
                        <span class="font-semibold text-[#0F172A]">{{ $kepengurusan->ukm->nama }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Jabatan</span>
                        <span class="font-semibold text-[#0F172A]">{{ $jabatanLabel }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Tanggal Daftar</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan->tanggal_daftar ? $keanggotaan->tanggal_daftar->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Tanggal Diterima</span>
                        <span class="font-semibold text-[#0F172A]">{{ $keanggotaan && $keanggotaan->status === 'diterima' ? $keanggotaan->updated_at->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Tanggal Bergabung</span>
                        <span class="font-semibold text-[#0F172A]">{{ $kepengurusan->tanggal_mulai ? $kepengurusan->tanggal_mulai->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">Status</span>
                        <span>
                            @if($kepengurusan->status === 'aktif')
                                <span class="portal-badge portal-badge-success">Aktif</span>
                            @else
                                <span class="portal-badge portal-badge-error">Nonaktif</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#64748B]">File KTM</span>
                        <span>
                            @if($keanggotaan && $keanggotaan->ktm)
                                <a href="{{ asset('storage/' . $keanggotaan->ktm) }}" target="_blank" class="text-[#0B2D4A] hover:underline font-semibold inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Lihat KTM
                                </a>
                            @else
                                <span class="text-[#64748B]">-</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="portal-card p-6 flex flex-wrap gap-3">
        <button onclick="openJabatanModal()" class="portal-btn portal-btn-gold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Ubah Jabatan
        </button>
        <form action="{{ route('user.status', $kepengurusan) }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="status" value="{{ $kepengurusan->status === 'aktif' ? 'nonaktif' : 'aktif' }}">
            @if($kepengurusan->status === 'aktif')
                <button type="submit" onclick="return confirm('Nonaktifkan anggota ini? Data tetap tersimpan.')" class="portal-btn portal-btn-danger">
                    Nonaktifkan
                </button>
            @else
                <button type="submit" class="portal-btn portal-btn-green">
                    Aktifkan
                </button>
            @endif
        </form>
    </div>
</div>

<!-- Modal Ubah Jabatan -->
<div id="jabatan-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white border border-[#C8D1DC] w-full max-w-sm p-6 shadow-xl">
        <h3 class="text-xl font-bold text-[#0B2D4A] mb-4">Ubah Jabatan</h3>
        <form action="{{ route('user.jabatan', $kepengurusan) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="portal-label">Jabatan</label>
                <select name="jabatan_id" class="portal-select">
                    @foreach(\App\Models\Jabatan::orderBy('level')->get() as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ $jabatan->id == $kepengurusan->jabatan_id ? 'selected' : '' }}>{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeModal()" class="portal-btn portal-btn-secondary flex-1">Batal</button>
                <button type="submit" class="portal-btn portal-btn-gold flex-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openJabatanModal() {
        document.getElementById('jabatan-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('jabatan-modal').classList.add('hidden');
    }
</script>
@endsection

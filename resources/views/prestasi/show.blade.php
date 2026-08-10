@extends('layouts.app')

@section('title', 'Detail Prestasi')

@section('breadcrumb', 'Detail Prestasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 h-28"></div>
        <div class="px-6 md:px-8 pb-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4 -mt-6">
                <div>
                    <span class="inline-block bg-white shadow px-3 py-1 rounded-none text-sm font-semibold text-amber-700 mb-3">🏆 Prestasi</span>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $prestasi->nama_prestasi }}</h1>
                    <p class="text-slate-500 mt-1 flex items-center gap-2">
                        <span class="badge-soft bg-slate-100 text-slate-700 border-slate-200">{{ $prestasi->ukm->nama ?? '-' }}</span>
                        @include('partials._status-badge', ['status' => $prestasi->tingkat])
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('prestasi.edit', $prestasi) }}" class="btn btn-amber">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('prestasi.destroy', $prestasi) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus prestasi ini?');" class="btn btn-red">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Piagam preview -->
    @if($prestasi->piagam)
        <div class="card p-6 mt-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4">📜 Piagam / Bukti</h2>
            <div class="flex justify-center bg-slate-50 rounded-none p-4 border border-dashed border-slate-300">
                <img src="{{ asset('storage/' . $prestasi->piagam) }}" alt="Piagam" class="max-w-full max-h-96 object-contain rounded-none shadow">
            </div>
            <a href="{{ asset('storage/' . $prestasi->piagam) }}" target="_blank" class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-700 font-semibold text-sm mt-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Buka gambar ukuran penuh
            </a>
        </div>
    @endif

    <!-- Detail informasi -->
    <div class="card p-6 md:p-8 mt-6">
        <h2 class="text-lg font-bold text-slate-900 mb-5 border-b pb-3">Informasi Prestasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Prestasi</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $prestasi->nama_prestasi }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">UKM</span>
                    <span class="font-semibold text-slate-800">{{ $prestasi->ukm->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Penerima</span>
                    <span class="font-semibold text-slate-800">{{ $prestasi->user->name ?? '-' }}</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-slate-500">Tingkat</span>
                    <span class="font-semibold text-slate-800 capitalize">{{ $prestasi->tingkat }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal</span>
                    <span class="font-semibold text-slate-800">{{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Dibuat</span>
                    <span class="font-semibold text-slate-800">{{ $prestasi->created_at ? $prestasi->created_at->format('d M Y') : '-' }}</span>
                </div>
            </div>
        </div>

        @if($prestasi->deskripsi)
            <div class="mt-6 pt-5 border-t">
                <h3 class="font-semibold text-slate-700 mb-2">Deskripsi</h3>
                <p class="text-slate-600 leading-relaxed">{{ $prestasi->deskripsi }}</p>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('prestasi.index') }}" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-semibold text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke daftar prestasi
        </a>
    </div>
</div>
@endsection

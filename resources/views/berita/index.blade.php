@extends('layouts.app')

@section('title', 'Berita')

@section('breadcrumb', 'Berita')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="card p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">📰 Berita</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola berita dan informasi terbaru seputar unit kegiatan mahasiswa.</p>
        </div>
        <a href="{{ route('berita.create') }}" class="btn btn-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Tambah Berita
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card p-4">
        <form action="{{ route('berita.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="lg:col-span-2">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." class="w-full pl-9 px-4 py-2 border border-black focus:outline-none text-sm">
                </div>
            </div>
            <div>
                <select name="ukm" class="w-full px-4 py-2 border border-black focus:outline-none text-sm bg-white">
                    <option value="">Semua UKM</option>
                    @foreach($ukms as $ukm)
                        <option value="{{ $ukm->id }}" {{ request('ukm') == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-black focus:outline-none text-sm bg-white">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="lg:col-span-2 flex gap-2">
                <button type="submit" class="btn btn-black flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if(request('search') || request('ukm') || request('status'))
                    <a href="{{ route('berita.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Berita List -->
    <div class="card overflow-hidden">
        @if($beritas->isEmpty())
            <div class="p-12 text-center">
                <div class="text-6xl mb-4">📰</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Berita</h3>
                <p class="text-slate-500 mb-6">Tambahkan berita pertama untuk mulai membagikan informasi terbaru UKM.</p>
                <a href="{{ route('berita.create') }}" class="btn btn-black">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Tambah Berita
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul & Kategori</th>
                            <th>UKM</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Dashboard User</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beritas as $berita)
                            <tr>
                                <td class="w-20">
                                    @if($berita->gambar)
                                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-14 h-14 object-cover border border-black" alt="{{ $berita->judul }}">
                                    @else
                                        <div class="w-14 h-14 bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-semibold text-slate-800">{{ $berita->judul }}</p>
                                    @if($berita->kategori)
                                        <span class="text-xs text-slate-400 uppercase tracking-wider">{{ $berita->kategori }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-soft">{{ $berita->ukm->nama ?? 'Umum' }}</span>
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    @if($berita->status === 'published')
                                        <span class="badge-soft bg-black text-white border-black">Published</span>
                                    @else
                                        <span class="badge-soft">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- Toggle tampil_di_dashboard -->
                                    <form action="{{ route('berita.toggle-dashboard', $berita) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            title="{{ $berita->tampil_di_dashboard ? 'Klik untuk sembunyikan dari dashboard' : 'Klik untuk tampilkan di dashboard' }}"
                                            class="relative inline-flex items-center cursor-pointer"
                                        >
                                            <span class="w-10 h-5 flex items-center {{ $berita->tampil_di_dashboard ? 'bg-black' : 'bg-slate-200' }} border border-black transition-colors">
                                                <span class="inline-block w-4 h-4 bg-white border border-black transform transition-transform {{ $berita->tampil_di_dashboard ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('berita.edit', $berita) }}" class="inline-flex items-center gap-1 bg-white text-black hover:bg-black hover:text-white border border-black px-2.5 py-1.5 text-xs font-semibold transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('berita.destroy', $berita) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 bg-white text-black hover:bg-black hover:text-white border border-black px-2.5 py-1.5 text-xs font-semibold transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

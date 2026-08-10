@extends('layouts.app')

@section('title', 'Prestasi')

@section('breadcrumb', 'Prestasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="card p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">🏆 Prestasi</h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola prestasi seluruh unit kegiatan mahasiswa.</p>
        </div>
        <a href="{{ route('prestasi.create') }}" class="btn btn-amber">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Prestasi
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card p-4">
        <form action="{{ route('prestasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="lg:col-span-2">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama prestasi atau deskripsi..." class="w-full pl-9 px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm">
                </div>
            </div>
            <div>
                <select name="ukm" class="w-full px-4 py-2 border rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm bg-white">
                    <option value="">Semua UKM</option>
                    @foreach($ukms as $ukm)
                        <option value="{{ $ukm->id }}" {{ request('ukm') == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-amber flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if(request('search') || request('ukm'))
                    <a href="{{ route('prestasi.index') }}" class="btn btn-ghost">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Prestasi List -->
    <div class="card overflow-hidden">
        @if($prestasis->isEmpty())
            <div class="p-12 text-center">
                <div class="text-6xl mb-4">🏆</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Data Prestasi</h3>
                <p class="text-slate-500 mb-6">Tambahkan prestasi pertama untuk mulai mencatat pencapaian UKM.</p>
                <a href="{{ route('prestasi.create') }}" class="btn btn-amber">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Prestasi
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>Prestasi</th>
                            <th>UKM</th>
                            <th>Tingkat</th>
                            <th>Tanggal</th>
                            <th class="text-center">Piagam</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($prestasis as $prestasi)
                            <tr>
                                <td>
                                    <p class="font-semibold text-slate-800">{{ $prestasi->nama_prestasi }}</p>
                                    @if($prestasi->deskripsi)
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $prestasi->deskripsi }}</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge-soft bg-slate-100 text-slate-700 border-slate-200">
                                        {{ $prestasi->ukm->nama ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @include('partials._status-badge', ['status' => $prestasi->tingkat])
                                </td>
                                <td>{{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</td>
                                <td class="text-center">
                                    @if($prestasi->piagam)
                                        <a href="{{ asset('storage/' . $prestasi->piagam) }}" target="_blank" title="Lihat piagam" class="inline-flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $prestasi->piagam) }}" class="w-9 h-9 object-cover rounded-none ring-1 ring-slate-200" alt="Piagam">
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('prestasi.show', $prestasi) }}" class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 px-2.5 py-1.5 rounded-none text-xs font-semibold transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('prestasi.edit', $prestasi) }}" class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 px-2.5 py-1.5 rounded-none text-xs font-semibold transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('prestasi.destroy', $prestasi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 px-2.5 py-1.5 rounded-none text-xs font-semibold transition">
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

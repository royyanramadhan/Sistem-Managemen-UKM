@extends('layouts.app')

@section('title', 'Organisasi UKM')
@section('breadcrumb', 'Organisasi UKM')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="portal-page-header">
        <div>
            <h1 class="portal-page-title">Organisasi UKM</h1>
            <p class="portal-page-subtitle">Kelola seluruh unit kegiatan mahasiswa Universitas Malikussaleh.</p>
        </div>
        <a href="{{ route('ukm.create') }}" class="portal-btn portal-btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah UKM
        </a>
    </div>

    @if($ukms->isEmpty())
        <div class="portal-card portal-empty">
            <div class="portal-empty-icon text-5xl">🏛️</div>
            <h3 class="portal-empty-title">Belum Ada UKM</h3>
            <p class="portal-empty-text mb-6">Tambahkan unit kegiatan mahasiswa pertama.</p>
            <a href="{{ route('ukm.create') }}" class="portal-btn portal-btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah UKM
            </a>
        </div>
    @else
        <div class="portal-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Logo</th>
                            <th>Nama</th>
                            <th>Bidang</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Prestasi</th>
                            <th class="text-center">Kegiatan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($ukms as $index => $ukm)
                            <tr class="portal-reveal {{ $index < 5 ? 'portal-stagger-' . ($index + 1) : '' }}">
                                <td class="text-center text-slate-400">{{ $index + 1 }}</td>
                                <td>
                                    @if($ukm->logo)
                                        <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama }}" class="w-11 h-11 object-cover border border-[#E2E8F0]">
                                    @else
                                        <div class="w-11 h-11 bg-[#EEF1F5] border border-[#E2E8F0] flex items-center justify-center text-slate-400">🏛️</div>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-semibold text-slate-800">{{ $ukm->nama }}</p>
                                    @if($ukm->email)
                                        <p class="text-xs text-slate-400">{{ $ukm->email }}</p>
                                    @endif
                                </td>
                                <td>
                                    <span class="portal-badge portal-badge-green">{{ $ukm->bidang }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-slate-700">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        {{ $ukm->kepengurusans_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-slate-700">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        {{ $ukm->prestasis_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="inline-flex items-center gap-1 text-sm font-semibold text-slate-700">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $ukm->kegiatans_count }}
                                    </span>
                                </td>
                                <td>
                                    @include('partials._status-badge', ['status' => $ukm->status])
                                </td>
                                <td>
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('ukm.show', $ukm) }}" class="portal-btn portal-btn-secondary text-xs px-2.5 py-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('ukm.edit', $ukm) }}" class="portal-btn portal-btn-ghost text-xs px-2.5 py-1.5" style="border-color: #B8952E; color: #7A6020; background: #F5EFE0;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('ukm.destroy', $ukm) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus UKM ini? Semua data terkait akan ikut terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="portal-btn portal-btn-danger text-xs px-2.5 py-1.5">
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
        </div>
    @endif
</div>
@endsection

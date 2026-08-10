@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('breadcrumb', 'Overview')

@section('content')
@php
    $maxChart = $chartValues->max() ?: 1;
    $statCards = [
        ['key' => 'ukm', 'label' => 'Total UKM', 'sub' => 'Organisasi terdaftar', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'icon_class' => 'portal-stat-icon-navy'],
        ['key' => 'mahasiswa', 'label' => 'Total User', 'sub' => 'Pengguna sistem', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'icon_class' => 'portal-stat-icon-green'],
        ['key' => 'anggota_aktif', 'label' => 'Anggota Aktif', 'sub' => 'Mahasiswa aktif', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'icon_class' => 'portal-stat-icon-green'],
        ['key' => 'pending', 'label' => 'Pendaftaran Pending', 'sub' => 'Menunggu persetujuan', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'icon_class' => 'portal-stat-icon-gold'],
        ['key' => 'prestasi', 'label' => 'Total Prestasi', 'sub' => 'Prestasi tercatat', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'icon_class' => 'portal-stat-icon-gold'],
    ];
    $activityIcons = [
        'pendaftaran' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',
        'kegiatan' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'prestasi' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
    ];
    $activityBg = ['pendaftaran' => 'bg-[#143D5C]', 'kegiatan' => 'bg-[#1A4D3E]', 'prestasi' => 'bg-[#7A6020]'];
    $progressColors = ['bg-[#0B2D4A]', 'bg-[#1A4D3E]', 'bg-[#B8952E]', 'bg-[#143D5C]', 'bg-[#236B55]', 'bg-[#CBA83A]'];
@endphp

<div class="space-y-6">

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3 lg:gap-4">
        @foreach($statCards as $index => $card)
        <div class="portal-stat-card portal-reveal {{ $index < 5 ? 'portal-stagger-' . ($index + 1) : '' }}">
            <div class="portal-stat-card-icon {{ $card['icon_class'] }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
            </div>
            <p class="portal-counter text-2xl lg:text-3xl font-bold text-slate-900 leading-none" data-counter-value="{{ $stats[$card['key']] }}" data-counter-duration="900">{{ $stats[$card['key']] }}</p>
            <p class="text-sm font-semibold text-slate-700 mt-1.5">{{ $card['label'] }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $card['sub'] }}</p>
        </div>
        @endforeach
    </div>

    @if($stats['pending'] > 0)
    <div class="portal-reveal flex flex-col sm:flex-row sm:items-center gap-3 portal-card px-4 py-3 border border-amber-200 bg-amber-50/50">
        <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-medium text-amber-800 flex-1">Ada <strong>{{ $stats['pending'] }}</strong> pendaftaran menunggu persetujuan.</p>
        <a href="{{ route('admin.keanggotaan') }}" class="text-[#B8952E] font-semibold hover:underline text-sm shrink-0">Kelola &rarr;</a>
    </div>
    @endif

    {{-- Main two-column layout --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Left: Main panel --}}
        <div class="portal-reveal xl:col-span-2 portal-card p-6 lg:p-8">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-900">Ringkasan Admin</h1>
                    <p class="text-sm text-slate-400 mt-1">Update terakhir: {{ $lastUpdated }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <div class="flex -space-x-2">
                        @foreach($recentRegistrations->take(3) as $reg)
                            <div class="w-8 h-8 bg-[#143D5C] ring-2 ring-white flex items-center justify-center text-white text-xs font-bold" title="{{ $reg->user->name ?? '' }}">
                                {{ strtoupper(substr($reg->user->name ?? '?', 0, 1)) }}
                            </div>
                        @endforeach
                        @if($recentRegistrations->isEmpty())
                            <div class="w-8 h-8 bg-slate-200 ring-2 ring-white flex items-center justify-center text-slate-400 text-xs">—</div>
                        @endif
                    </div>
                    <a href="{{ route('ukm.create') }}" class="w-8 h-8 bg-[#0B2D4A] text-white flex items-center justify-center hover:bg-[#143D5C] transition-colors" title="Tambah UKM">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </a>
                </div>
            </div>

            {{-- Bar chart --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-slate-600">Aktivitas 30 Hari Terakhir</p>
                    <span class="text-xs text-slate-400">Pendaftaran · Kegiatan · Prestasi</span>
                </div>
                <div class="flex items-end gap-[3px] sm:gap-1 h-28 sm:h-36 px-1">
                    @foreach($chartValues as $index => $value)
                        @php $height = max(4, ($value / $maxChart) * 100); @endphp
                        <div class="flex-1 flex flex-col items-center justify-end h-full group relative">
                            <div class="portal-progress-animate w-full transition-all duration-700 ease-out {{ $index === $chartHighlight ? 'bg-[#B8952E]' : 'bg-[#B8952E]/20 group-hover:bg-[#B8952E]/40' }}"
                                 data-progress-target="{{ $height }}"
                                 data-progress-axis="height"
                                 style="height: 0%;"></div>
                            @if($index % 5 === 0)
                                <span class="text-[9px] text-slate-300 mt-1 hidden sm:block">{{ $chartLabels[$index] ?? '' }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent activities --}}
            <div>
                <h2 class="text-lg font-bold text-slate-900 mb-4">Aktivitas Terbaru</h2>

                @if($recentActivities->isEmpty())
                    <div class="text-center py-10">
                        <div class="text-4xl mb-2">📋</div>
                        <p class="text-slate-400 text-sm">Belum ada aktivitas terbaru.</p>
                    </div>
                @else
                    @foreach($recentActivities as $groupLabel => $items)
                        <div class="mb-5 portal-reveal">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">{{ $groupLabel }}</p>
                            <div class="space-y-1">
                                @foreach($items as $activity)
                                <div class="flex items-center gap-3 py-3 px-2 -mx-2 hover:bg-slate-50 transition-colors">
                                    <div class="w-9 h-9 {{ $activityBg[$activity['type']] ?? 'bg-[#0B2D4A]' }} flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activityIcons[$activity['type']] ?? $activityIcons['pendaftaran'] }}"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $activity['date']->format('H:i') }} · {{ $activity['subtitle'] }}</p>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-500 shrink-0 hidden sm:block">{{ $activity['value'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Right panel --}}
        <div class="space-y-6">

            {{-- Distribusi UKM per Bidang --}}
            <div class="portal-reveal portal-card p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-1">Distribusi UKM per Bidang</h2>
                <p class="text-xs text-slate-400 mb-5">Sebaran organisasi berdasarkan bidang kegiatan</p>

                @if($bidangDistribution->isEmpty())
                    <p class="text-sm text-slate-400 text-center py-6">Belum ada data UKM.</p>
                @else
                    <div class="space-y-4">
                        @foreach($bidangDistribution as $index => $item)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm font-medium text-slate-700 truncate mr-2">{{ $item['bidang'] }}</span>
                                <span class="text-sm font-bold text-slate-900 shrink-0">{{ $item['total'] }}</span>
                            </div>
                            <div class="portal-progress">
                                <div class="portal-progress-bar portal-progress-animate {{ $index % 3 === 1 ? 'portal-progress-bar-green' : ($index % 3 === 2 ? 'portal-progress-bar-gold' : '') }} transition-all duration-700 ease-out"
                                     data-progress-target="{{ $item['percentage'] }}"
                                     data-progress-axis="width"
                                     style="width: 0%;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- CTA Card --}}
            <div class="portal-reveal portal-card p-6 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#B8952E]/8" style="transform: rotate(15deg);"></div>
                <div class="absolute right-4 bottom-4 w-12 h-12 bg-[#B8952E]/12" style="transform: rotate(15deg);"></div>
                <div class="relative">
                    <div class="portal-stat-card-icon portal-stat-icon-gold mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Lengkapi Data UKM</h3>
                    <p class="text-xs text-slate-400 mb-5 leading-relaxed">Pastikan profil dan informasi setiap organisasi UKM sudah lengkap dan terkini.</p>
                    <a href="{{ route('ukm.index') }}" class="portal-btn portal-btn-primary text-xs uppercase tracking-wide px-5">
                        Lihat UKM
                    </a>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="portal-reveal portal-card">
                <div class="px-5 pt-4 pb-2">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi Cepat</p>
                </div>
                <a href="{{ route('ukm.create') }}" class="portal-quick-action group">
                    <div class="portal-quick-action-icon portal-stat-icon-navy">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-[#0B2D4A]">Tambah UKM</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('user.index') }}" class="portal-quick-action group">
                    <div class="portal-quick-action-icon portal-stat-icon-green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-[#0B2D4A]">Kelola Anggota</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('prestasi.create') }}" class="portal-quick-action group">
                    <div class="portal-quick-action-icon portal-stat-icon-gold">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-[#0B2D4A]">Tambah Prestasi</span>
                    <svg class="w-4 h-4 text-slate-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Tables: Pendaftaran & Prestasi terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent registrations --}}
        <div class="portal-reveal portal-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900">Pendaftaran Terbaru</h2>
                <a href="{{ route('admin.keanggotaan') }}" class="text-[#B8952E] hover:underline font-semibold text-xs">Lihat Semua</a>
            </div>
            @if($recentRegistrations->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-slate-400 text-sm">Belum ada data pendaftaran.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="data-table w-full text-left text-sm text-slate-600">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>UKM</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRegistrations as $item)
                            <tr>
                                <td>
                                    <p class="font-medium text-slate-800">{{ $item->user->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->created_at->format('d M Y') }}</p>
                                </td>
                                <td>{{ $item->ukm->nama ?? '-' }}</td>
                                <td>@include('partials._status-badge', ['status' => $item->status])</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Recent prestasi --}}
        <div class="portal-reveal portal-card overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900">Prestasi Terbaru</h2>
                <a href="{{ route('prestasi.index') }}" class="text-[#B8952E] hover:underline font-semibold text-xs">Lihat Semua</a>
            </div>
            @if($recentPrestasi->isEmpty())
                <div class="p-10 text-center">
                    <p class="text-slate-400 text-sm mb-3">Belum ada data prestasi.</p>
                    <a href="{{ route('prestasi.create') }}" class="portal-btn portal-btn-primary text-xs">Tambah Prestasi</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="data-table w-full text-left text-sm text-slate-600">
                        <thead>
                            <tr>
                                <th>Prestasi</th>
                                <th>UKM</th>
                                <th>Tingkat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPrestasi as $prestasi)
                            <tr>
                                <td>
                                    <p class="font-medium text-slate-800">{{ $prestasi->nama_prestasi }}</p>
                                    <p class="text-xs text-slate-400">{{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</p>
                                </td>
                                <td>{{ $prestasi->ukm->nama ?? '-' }}</td>
                                <td>@include('partials._status-badge', ['status' => $prestasi->tingkat])</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

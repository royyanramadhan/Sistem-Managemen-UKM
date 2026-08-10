@extends('layouts.public')

@section('title', $kegiatan->nama . ' — Kegiatan UKM')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Back Button --}}
    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-[#D97706] font-medium mb-8 transition-colors group">
        <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Beranda
    </a>

    {{-- Header Card --}}
    <div class="bg-white rounded-none shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-[#D97706] to-[#F97316] h-36 relative">
            <div class="absolute inset-0 opacity-10"
                style="background-image: url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='1' fill-rule='evenodd'%3E%3Ccircle cx='20' cy='20' r='3'/%3E%3C/g%3E%3C/svg%3E\");">
            </div>
        </div>
        <div class="px-6 md:px-10 pb-8">
            <div class="flex flex-col md:flex-row items-start gap-6 -mt-8 mb-6">
                {{-- Icon --}}
                <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-none bg-white border-4 border-white shadow-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="pt-2 flex-1 min-w-0">
                    {{-- Badges --}}
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="inline-block px-3 py-1 rounded-none text-xs font-bold uppercase bg-[#D97706]/10 text-[#D97706] border border-[#D97706]/20">
                            {{ $kegiatan->jenis ?? 'Kegiatan' }}
                        </span>
                        @php
                            $statusColors = [
                                'direncanakan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'berlangsung'  => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'selesai'      => 'bg-slate-100 text-slate-600 border-slate-200',
                                'dibatalkan'   => 'bg-red-100 text-red-600 border-red-200',
                            ];
                            $statusClass = $statusColors[$kegiatan->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                        @endphp
                        @if($kegiatan->status)
                            <span class="inline-block px-3 py-1 rounded-none text-xs font-bold uppercase border {{ $statusClass }}">
                                {{ $kegiatan->status }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#1F2937] leading-tight">
                        {{ $kegiatan->nama }}
                    </h1>
                    @if($kegiatan->ukm)
                        <a href="{{ route('ukm.public.show', $kegiatan->ukm) }}"
                           class="inline-flex items-center gap-1.5 mt-2 text-[#D97706] font-semibold hover:text-[#B45309] transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $kegiatan->ukm->nama }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Informasi --}}
    <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 md:p-8 mt-6">
        <h2 class="text-xl font-bold text-[#1F2937] mb-6 pb-3 border-b border-slate-100">
            📋 Informasi Kegiatan
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-8 text-sm">

            {{-- Tanggal Mulai --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tanggal Mulai</p>
                    <p class="font-semibold text-[#1F2937]">
                        {{ $kegiatan->tanggal_mulai ? $kegiatan->tanggal_mulai->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>

            {{-- Tanggal Selesai --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tanggal Selesai</p>
                    <p class="font-semibold text-[#1F2937]">
                        {{ $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('d F Y') : 'Belum ditentukan' }}
                    </p>
                </div>
            </div>

            {{-- Tempat --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tempat</p>
                    <p class="font-semibold text-[#1F2937]">{{ $kegiatan->tempat ?: 'Belum ditentukan' }}</p>
                </div>
            </div>

            {{-- Jenis --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Jenis Kegiatan</p>
                    <p class="font-semibold text-[#1F2937] capitalize">{{ $kegiatan->jenis ?: '-' }}</p>
                </div>
            </div>

            {{-- UKM --}}
            @if($kegiatan->ukm)
            <div class="flex items-start gap-3 sm:col-span-2">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Unit Kegiatan Mahasiswa</p>
                    <a href="{{ route('ukm.public.show', $kegiatan->ukm) }}"
                       class="font-semibold text-[#D97706] hover:text-[#B45309] hover:underline transition-colors">
                        {{ $kegiatan->ukm->nama }}
                    </a>
                </div>
            </div>
            @endif

        </div>

        {{-- Deskripsi --}}
        @if($kegiatan->deskripsi)
            <div class="mt-8 pt-6 border-t border-slate-100">
                <h3 class="text-base font-bold text-[#1F2937] mb-3">Deskripsi Kegiatan</h3>
                <p class="text-[#1F2937]/70 leading-relaxed whitespace-pre-wrap">{{ $kegiatan->deskripsi }}</p>
            </div>
        @endif
    </div>

    {{-- CTA daftar UKM --}}
    @if($kegiatan->ukm)
    <div class="bg-gradient-to-r from-[#D97706] to-[#F97316] rounded-none p-8 md:p-10 mt-6 text-center text-white shadow-lg">
        <h2 class="text-xl md:text-2xl font-bold mb-2">
            Tertarik bergabung dengan {{ $kegiatan->ukm->nama }}?
        </h2>
        <p class="text-orange-100 mb-6 text-sm">Kembangkan potensimu bersama komunitas ini.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('ukm.public.show', $kegiatan->ukm) }}"
               class="px-6 py-3 rounded-none bg-white text-[#D97706] font-bold hover:bg-orange-50 transition-all hover:-translate-y-0.5 shadow-lg text-sm">
                Lihat Profil UKM
            </a>
            @guest
                <a href="{{ route('login') }}"
                   class="px-6 py-3 rounded-none border-2 border-white/40 text-white font-semibold hover:bg-white/10 transition-all text-sm">
                    Masuk / Daftar
                </a>
            @endguest
        </div>
    </div>
    @endif

</div>
@endsection

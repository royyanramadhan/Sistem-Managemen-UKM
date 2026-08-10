@extends('layouts.public')

@section('title', $prestasi->nama_prestasi . ' — Prestasi UKM')

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
                {{-- Trophy Icon --}}
                <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-none bg-white border-4 border-white shadow-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>

                <div class="pt-2 flex-1 min-w-0">
                    {{-- Tingkat badge --}}
                    @php
                        $tingkatColors = [
                            'lokal'           => 'bg-slate-100 text-slate-700 border-slate-200',
                            'regional'        => 'bg-blue-100 text-blue-700 border-blue-200',
                            'nasional'        => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'internasional'   => 'bg-purple-100 text-purple-700 border-purple-200',
                        ];
                        $tingkatClass = $tingkatColors[$prestasi->tingkat] ?? 'bg-[#D97706]/10 text-[#D97706] border-[#D97706]/20';
                    @endphp
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="inline-block px-3 py-1 rounded-none text-xs font-bold uppercase bg-[#D97706] text-white">
                            🏆 Prestasi
                        </span>
                        <span class="inline-block px-3 py-1 rounded-none text-xs font-bold uppercase border {{ $tingkatClass }}">
                            {{ $prestasi->tingkat }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-[#1F2937] leading-tight">
                        {{ $prestasi->nama_prestasi }}
                    </h1>
                    @if($prestasi->ukm)
                        <a href="{{ route('ukm.public.show', $prestasi->ukm) }}"
                           class="inline-flex items-center gap-1.5 mt-2 text-[#D97706] font-semibold hover:text-[#B45309] transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $prestasi->ukm->nama }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Piagam / Bukti --}}
    @if($prestasi->piagam)
    <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 md:p-8 mt-6">
        <h2 class="text-xl font-bold text-[#1F2937] mb-5 pb-3 border-b border-slate-100">📜 Piagam / Bukti</h2>
        <div class="flex justify-center bg-slate-50 rounded-none p-4 border border-dashed border-slate-200">
            <img src="{{ asset('storage/' . $prestasi->piagam) }}"
                 alt="Piagam {{ $prestasi->nama_prestasi }}"
                 class="max-w-full max-h-96 object-contain rounded-none shadow">
        </div>
        <div class="mt-4 flex justify-center">
            <a href="{{ asset('storage/' . $prestasi->piagam) }}" target="_blank"
               class="inline-flex items-center gap-2 text-[#D97706] hover:text-[#B45309] font-semibold text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Buka gambar ukuran penuh
            </a>
        </div>
    </div>
    @endif

    {{-- Detail Informasi --}}
    <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 md:p-8 mt-6">
        <h2 class="text-xl font-bold text-[#1F2937] mb-6 pb-3 border-b border-slate-100">
            📋 Informasi Prestasi
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-8 text-sm">

            {{-- Nama Prestasi --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Nama Prestasi</p>
                    <p class="font-semibold text-[#1F2937]">{{ $prestasi->nama_prestasi }}</p>
                </div>
            </div>

            {{-- Tingkat --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tingkat</p>
                    <p class="font-semibold text-[#1F2937] capitalize">{{ $prestasi->tingkat }}</p>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Tanggal</p>
                    <p class="font-semibold text-[#1F2937]">
                        {{ $prestasi->tanggal ? $prestasi->tanggal->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>

            {{-- Penerima --}}
            @if($prestasi->user)
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Penerima Prestasi</p>
                    <p class="font-semibold text-[#1F2937]">{{ $prestasi->user->name }}</p>
                </div>
            </div>
            @endif

            {{-- UKM --}}
            @if($prestasi->ukm)
            <div class="flex items-start gap-3 sm:col-span-2">
                <div class="flex-shrink-0 w-9 h-9 rounded-none bg-[#D97706]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-0.5">Unit Kegiatan Mahasiswa</p>
                    <a href="{{ route('ukm.public.show', $prestasi->ukm) }}"
                       class="font-semibold text-[#D97706] hover:text-[#B45309] hover:underline transition-colors">
                        {{ $prestasi->ukm->nama }}
                    </a>
                </div>
            </div>
            @endif

        </div>

        {{-- Deskripsi --}}
        @if($prestasi->deskripsi)
            <div class="mt-8 pt-6 border-t border-slate-100">
                <h3 class="text-base font-bold text-[#1F2937] mb-3">Keterangan</h3>
                <p class="text-[#1F2937]/70 leading-relaxed whitespace-pre-wrap">{{ $prestasi->deskripsi }}</p>
            </div>
        @endif
    </div>

    {{-- CTA daftar UKM --}}
    @if($prestasi->ukm)
    <div class="bg-gradient-to-r from-[#D97706] to-[#F97316] rounded-none p-8 md:p-10 mt-6 text-center text-white shadow-lg">
        <h2 class="text-xl md:text-2xl font-bold mb-2">
            Tertarik bergabung dengan {{ $prestasi->ukm->nama }}?
        </h2>
        <p class="text-orange-100 mb-6 text-sm">Raih prestasi membanggakan bersama komunitas ini.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('ukm.public.show', $prestasi->ukm) }}"
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

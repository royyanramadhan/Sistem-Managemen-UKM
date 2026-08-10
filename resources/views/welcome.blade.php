@extends('layouts.public')

@section('title', 'Portal UKM')

@php
    $kategori = $ukms->groupBy('bidang')->take(4);
    $prestasis = $ukms->flatMap->prestasis->sortByDesc('tanggal')->take(6);
    $events = $ukms->flatMap->kegiatans->sortByDesc('tanggal_mulai')->take(6);
@endphp

@section('content')

{{-- HERO --}}
<section id="beranda" class="bg-white border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-20">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="portal-fade-in">
                <p class="portal-section-label">Universitas Malikussaleh</p>
                <h1 class="text-3xl md:text-4xl xl:text-5xl font-bold text-[#0B2D4A] leading-tight mb-5">
                    Portal Unit Kegiatan Mahasiswa
                </h1>
                <p class="text-base lg:text-lg text-[#475569] mb-8 max-w-xl leading-relaxed">
                    Sistem informasi terpadu untuk manajemen UKM, pendaftaran keanggotaan, kegiatan, dan prestasi mahasiswa Universitas Malikussaleh.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#ukm" class="portal-btn portal-btn-primary px-6 py-3">Lihat Daftar UKM</a>
                    <a href="{{ route('login') }}" class="portal-btn portal-btn-secondary px-6 py-3">Masuk Akun</a>
                </div>
            </div>
            <div class="hidden lg:block portal-reveal portal-reveal-right">
                <div class="border border-[#C8D1DC] bg-[#F8FAFC] p-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="portal-stat">
                            <p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['ukm'] }}">{{ $stats['ukm'] }}</p>
                            <p class="portal-stat-label">Unit Kegiatan</p>
                        </div>
                        <div class="portal-stat">
                            <p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['mahasiswa'] }}">{{ $stats['mahasiswa'] }}</p>
                            <p class="portal-stat-label">Mahasiswa</p>
                        </div>
                        <div class="portal-stat">
                            <p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['pendaftaran'] }}">{{ $stats['pendaftaran'] }}</p>
                            <p class="portal-stat-label">Pendaftaran</p>
                        </div>
                        <div class="portal-stat">
                            <p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['kegiatan'] }}">{{ $stats['kegiatan'] }}</p>
                            <p class="portal-stat-label">Kegiatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATISTIK MOBILE --}}
<section class="lg:hidden bg-[#F8FAFC] border-b border-[#E2E8F0]">
    <div class="portal-container py-6">
        <div class="grid grid-cols-2 gap-3">
            <div class="portal-stat"><p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['ukm'] }}">{{ $stats['ukm'] }}</p><p class="portal-stat-label">UKM</p></div>
            <div class="portal-stat"><p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['mahasiswa'] }}">{{ $stats['mahasiswa'] }}</p><p class="portal-stat-label">Mahasiswa</p></div>
            <div class="portal-stat"><p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['pendaftaran'] }}">{{ $stats['pendaftaran'] }}</p><p class="portal-stat-label">Pendaftaran</p></div>
            <div class="portal-stat"><p class="portal-stat-value portal-counter" data-counter-value="{{ $stats['kegiatan'] }}">{{ $stats['kegiatan'] }}</p><p class="portal-stat-label">Kegiatan</p></div>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section id="tentang" class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="portal-reveal">
                <p class="portal-section-label">Tentang Portal</p>
                <h2 class="portal-section-title mb-5">Platform Manajemen UKM Terintegrasi</h2>
                <p class="text-[#475569] mb-6 leading-relaxed">
                    Portal UKM Universitas Malikussaleh memfasilitasi mahasiswa dalam menemukan, mendaftar, dan beraktivitas di berbagai unit kegiatan mahasiswa secara terstruktur dan transparan.
                </p>
                <ul class="space-y-3 text-sm text-[#475569]">
                    <li class="flex items-start gap-3"><span class="text-[#1A4D3E] font-bold mt-0.5">—</span> Pendaftaran keanggotaan UKM secara online</li>
                    <li class="flex items-start gap-3"><span class="text-[#1A4D3E] font-bold mt-0.5">—</span> Informasi kegiatan dan prestasi UKM</li>
                    <li class="flex items-start gap-3"><span class="text-[#1A4D3E] font-bold mt-0.5">—</span> Manajemen struktur kepengurusan</li>
                </ul>
            </div>
            <div class="portal-reveal portal-reveal-right bg-white border border-[#E2E8F0] p-8">
                <h3 class="font-bold text-[#0B2D4A] mb-4 text-lg">Layanan Portal</h3>
                <div class="space-y-4">
                    <div class="flex gap-4 pb-4 border-b border-[#E2E8F0]">
                        <div class="w-10 h-10 bg-[#0B2D4A] text-white flex items-center justify-center shrink-0 text-sm font-bold">01</div>
                        <div><p class="font-semibold text-[#0F172A]">Pendaftaran UKM</p><p class="text-sm text-[#64748B] mt-1">Mahasiswa dapat mendaftar ke UKM pilihan secara digital.</p></div>
                    </div>
                    <div class="flex gap-4 pb-4 border-b border-[#E2E8F0]">
                        <div class="w-10 h-10 bg-[#1A4D3E] text-white flex items-center justify-center shrink-0 text-sm font-bold">02</div>
                        <div><p class="font-semibold text-[#0F172A]">Manajemen Data</p><p class="text-sm text-[#64748B] mt-1">Admin mengelola organisasi, anggota, dan struktur kepengurusan.</p></div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-[#B8952E] text-white flex items-center justify-center shrink-0 text-sm font-bold">03</div>
                        <div><p class="font-semibold text-[#0F172A]">Informasi Publik</p><p class="text-sm text-[#64748B] mt-1">Akses informasi UKM, prestasi, kegiatan, dan berita terkini.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- UKM --}}
<section id="ukm" class="bg-white border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <p class="portal-section-label">Organisasi</p>
                <h2 class="portal-section-title">Unit Kegiatan Mahasiswa</h2>
            </div>
        </div>

        @if($ukms->isEmpty())
            <div class="portal-card p-12 text-center">
                <p class="text-[#64748B]">Belum ada data UKM.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($ukms as $index => $ukm)
                    <a href="{{ route('ukm.public.show', $ukm) }}" class="portal-card portal-reveal group block hover:border-[#0B2D4A] transition-colors {{ $index < 4 ? 'portal-stagger-' . ($index + 1) : '' }}">
                        <div class="h-44 overflow-hidden bg-[#F1F5F9] border-b border-[#E2E8F0]">
                            @if($ukm->logo)
                                <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl font-bold text-[#0B2D4A]/20">{{ strtoupper(substr($ukm->nama, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="portal-badge portal-badge-green text-[10px] mb-2">{{ $ukm->bidang }}</span>
                            <h3 class="font-bold text-[#0F172A] group-hover:text-[#0B2D4A] transition-colors">{{ $ukm->nama }}</h3>
                            <p class="text-sm text-[#64748B] mt-1 line-clamp-2">{{ Str::limit(strip_tags($ukm->deskripsi), 80) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- KATEGORI --}}
@if($kategori->isNotEmpty())
<section id="kategori" class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <p class="portal-section-label">Kategori</p>
        <h2 class="portal-section-title mb-8">Bidang UKM</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($kategori as $bidang => $items)
                <div class="portal-card portal-reveal p-5">
                    <h3 class="font-bold text-[#0B2D4A] capitalize mb-1">{{ $bidang }}</h3>
                    <p class="text-sm text-[#64748B] mb-3">{{ $items->count() }} UKM</p>
                    <a href="#ukm" class="text-sm font-semibold text-[#1A4D3E] hover:underline">Lihat &rarr;</a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- PRESTASI --}}
<section id="prestasi" class="bg-white border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <p class="portal-section-label">Prestasi</p>
        <h2 class="portal-section-title mb-8">Pencapaian Mahasiswa</h2>
        @if($prestasis->isEmpty())
            <div class="portal-card p-10 text-center text-[#64748B]">Belum ada data prestasi.</div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($prestasis as $index => $prestasi)
                    <a href="{{ route('prestasi.public.show', $prestasi) }}" class="portal-card portal-reveal p-5 block hover:border-[#0B2D4A] transition-colors {{ $index < 3 ? 'portal-stagger-' . ($index + 1) : '' }}">
                        <span class="portal-badge portal-badge-gold mb-3">{{ strtoupper($prestasi->tingkat) }}</span>
                        <h3 class="font-bold text-[#0F172A] mb-1">{{ $prestasi->nama_prestasi }}</h3>
                        <p class="text-sm text-[#1A4D3E] font-semibold mb-2">{{ $prestasi->ukm->nama ?? 'UKM' }}</p>
                        <p class="text-sm text-[#64748B] line-clamp-2">{{ $prestasi->deskripsi ?: '—' }}</p>
                        <p class="text-xs text-[#94A3B8] mt-3">{{ $prestasi->tanggal->format('d M Y') }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- KEGIATAN --}}
<section id="event" class="bg-[#F8FAFC] border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <p class="portal-section-label">Agenda</p>
        <h2 class="portal-section-title mb-8">Kegiatan & Event</h2>
        @if($events->isEmpty())
            <div class="portal-card p-10 text-center text-[#64748B]">Belum ada data kegiatan.</div>
        @else
            <div class="portal-card portal-reveal overflow-hidden">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>UKM</th>
                            <th>Jenis</th>
                            <th>Tempat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr class="cursor-pointer" onclick="window.location='{{ route('kegiatan.show', $event) }}'">
                                <td class="font-semibold whitespace-nowrap">{{ $event->tanggal_mulai->format('d M Y') }}</td>
                                <td class="font-semibold text-[#0F172A]">{{ $event->nama }}</td>
                                <td class="text-[#1A4D3E]">{{ $event->ukm->nama ?? '—' }}</td>
                                <td><span class="portal-badge">{{ $event->jenis }}</span></td>
                                <td class="text-[#64748B]">{{ $event->tempat ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>

{{-- BERITA --}}
<section id="berita" class="bg-white border-b border-[#E2E8F0]">
    <div class="portal-container py-14 lg:py-16">
        <p class="portal-section-label">Informasi</p>
        <h2 class="portal-section-title mb-8">Berita Terbaru</h2>
        @if($beritaLanding->isEmpty())
            <div class="portal-card p-10 text-center text-[#64748B]">Belum ada berita.</div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($beritaLanding as $index => $berita)
                    <div class="portal-card portal-reveal overflow-hidden {{ $index < 4 ? 'portal-stagger-' . ($index + 1) : '' }}">
                        <div class="h-48 bg-[#F1F5F9] border-b border-[#E2E8F0]">
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[#0B2D4A]/20">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="portal-badge portal-badge-navy text-[10px] mb-2">{{ $berita->kategori ?? ($berita->ukm->nama ?? 'Berita') }}</span>
                            <h3 class="font-bold text-[#0F172A] leading-snug">{{ $berita->judul }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- CTA --}}
<section class="bg-[#0B2D4A]">
    <div class="portal-container portal-reveal py-14 lg:py-16 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Bergabung dengan UKM</h2>
        <p class="text-slate-300 mb-8 max-w-lg mx-auto">Daftarkan diri dan temukan komunitas yang sesuai dengan minat dan bakat Anda.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('register') }}" class="portal-btn portal-btn-gold px-8 py-3">Daftar Sekarang</a>
            <a href="{{ route('login') }}" class="portal-btn portal-btn-secondary px-8 py-3 bg-transparent text-white border-white/30 hover:bg-white/10 hover:text-white">Masuk Akun</a>
        </div>
    </div>
</section>

@endsection

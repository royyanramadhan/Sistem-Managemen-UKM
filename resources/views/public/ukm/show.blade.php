@extends('layouts.public')

@section('title', $ukm->nama)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Back Button -->
<a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-orange-600 font-medium mb-6 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Beranda
    </a>

    <!-- Header -->
    <div class="bg-white border border-[#E2E8F0] overflow-hidden">
        <div class="bg-[#0B2D4A] h-36 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 1px, transparent 1px, transparent 12px);"></div>
        </div>
        <div class="px-6 md:px-10 pb-8">
            <div class="flex flex-col md:flex-row items-start md:items-end gap-6 -mt-16 mb-6">
                <div class="flex-shrink-0">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/' . $ukm->logo) }}" class="w-28 h-28 md:w-36 md:h-36 object-cover border-4 border-white bg-white">
                    @else
                        <div class="w-28 h-28 md:w-36 md:h-36 bg-[#EEF1F5] border-4 border-white flex items-center justify-center text-5xl">🏛️</div>
                    @endif
                </div>
                <div class="pt-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-3xl md:text-4xl font-bold text-slate-900">{{ $ukm->nama }}</h1>
                        @if($ukm->bidang)
                            <span class="portal-badge portal-badge-navy text-xs">{{ $ukm->bidang }}</span>
                        @endif
                    </div>
                    <p class="text-slate-600 mt-3 leading-relaxed">{{ $ukm->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                    @if($ukm->email || $ukm->telepon || $ukm->alamat)
                        <div class="flex flex-wrap gap-4 mt-4 text-sm text-slate-500">
                            @if($ukm->email)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $ukm->email }}
                                </span>
                            @endif
                            @if($ukm->telepon)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $ukm->telepon }}
                                </span>
                            @endif
                            @if($ukm->alamat)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $ukm->alamat }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <!-- Struktur Kepengurusan -->
    <div class="bg-white border border-[#E2E8F0] p-6 md:p-8 mt-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Struktur Kepengurusan</h2>
        @if($ukm->kepengurusans->count() > 0)
            @php
                $ketua = $ukm->kepengurusans->first(fn($k) => $k->jabatan->nama === 'Ketua Umum');
                $wakil = $ukm->kepengurusans->first(fn($k) => $k->jabatan->nama === 'Wakil Ketua');
                $sekretaris = $ukm->kepengurusans->first(fn($k) => $k->jabatan->nama === 'Sekretaris Umum');
                $bendahara = $ukm->kepengurusans->first(fn($k) => $k->jabatan->nama === 'Bendahara');
                $anggotaList = $ukm->kepengurusans->filter(fn($k) => $k->jabatan->nama === 'Anggota');
            @endphp
            <div class="tf-tree" style="overflow-x: auto;">
                <ul>
                    <li>
                        <div class="tf-nc">
                            <div class="tf-nc-title">Ketua Umum</div>
                            <div class="tf-nc-name">{{ $ketua ? $ketua->user->name : '-' }}</div>
                        </div>
                        <ul>
                            <li>
                                <div class="tf-nc">
                                    <div class="tf-nc-title">Wakil Ketua</div>
                                    <div class="tf-nc-name">{{ $wakil ? $wakil->user->name : '-' }}</div>
                                </div>
                                <ul>
                                    @if($sekretaris)
                                    <li>
                                        <div class="tf-nc">
                                            <div class="tf-nc-title">Sekretaris Umum</div>
                                            <div class="tf-nc-name">{{ $sekretaris->user->name }}</div>
                                        </div>
                                    </li>
                                    @endif
                                    @if($bendahara)
                                    <li>
                                        <div class="tf-nc">
                                            <div class="tf-nc-title">Bendahara</div>
                                            <div class="tf-nc-name">{{ $bendahara->user->name }}</div>
                                        </div>
                                    </li>
                                    @endif
                                    
                                    @foreach($divisis as $divisi)
                                    <li>
                                        <div class="tf-nc">
                                            <div class="tf-nc-title">Kepala Divisi {{ $divisi->nama }}</div>
                                            <div class="tf-nc-name" style="font-size: 0.72rem; color: #64748B; font-weight: 600;">Divisi</div>
                                        </div>
                                        @php
                                            $anggotaDivisi = $anggotaList->filter(fn($k) => $k->divisi_id === $divisi->id);
                                        @endphp
                                        @if($anggotaDivisi->count() > 0)
                                        <ul>
                                            @foreach($anggotaDivisi as $member)
                                            <li>
                                                <div class="tf-nc" style="padding: 5px 10px; min-width: 100px;">
                                                    <div class="tf-nc-name" style="font-size: 0.8rem;">{{ $member->user->name }}</div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @else
            <p class="text-center text-slate-400 py-6">Belum ada data kepengurusan.</p>
        @endif
    </div>

    <!-- Prestasi -->
    <div class="bg-white border border-[#E2E8F0] p-6 md:p-8 mt-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Prestasi</h2>
        @if($ukm->prestasis && $ukm->prestasis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ukm->prestasis as $index => $prestasi)
                    <div class="portal-reveal bg-[#F5EFE0] p-5 border border-[#D9C486] {{ $index < 3 ? 'portal-stagger-' . ($index + 1) : '' }}">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-[#7A6020]">{{ $prestasi->nama_prestasi }}</h3>
                            <span class="portal-badge portal-badge-gold">{{ $prestasi->tingkat }}</span>
                        </div>
                        <p class="text-slate-600 text-sm">{{ $prestasi->deskripsi ?? '-' }}</p>
                        <p class="text-xs text-[#7A6020] mt-3">📅 {{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-400 py-6">Belum ada prestasi.</p>
        @endif
    </div>

<!-- Kegiatan -->
    <div class="bg-white border border-[#E2E8F0] p-6 md:p-8 mt-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Kegiatan</h2>
        @if($ukm->kegiatans && $ukm->kegiatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ukm->kegiatans as $index => $kegiatan)
                    <div class="portal-reveal bg-[#E8EEF4] p-5 border border-[#B5C6D7] {{ $index < 3 ? 'portal-stagger-' . ($index + 1) : '' }}">
                        <h3 class="font-bold text-[#0B2D4A]">{{ $kegiatan->nama }}</h3>
                        <p class="text-slate-600 text-sm mt-2">{{ $kegiatan->deskripsi ?? '-' }}</p>
                        <p class="text-xs text-[#475569] mt-3">📍 {{ $kegiatan->tempat ?? '-' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-slate-400 py-6">Belum ada kegiatan.</p>
        @endif
    </div>

    <!-- Berita -->
    @if(isset($ukmBeritas) && $ukmBeritas->count() > 0)
    <div class="bg-white border border-[#E2E8F0] p-6 md:p-8 mt-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">📰 Berita</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ukmBeritas as $berita)
                <div class="bg-slate-50 rounded-none overflow-hidden border border-slate-200">
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-slate-200 to-slate-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <div class="p-4">
                        @if($berita->kategori)
                            <span class="text-[#D97706] text-xs font-bold uppercase tracking-wider">{{ $berita->kategori }}</span>
                        @endif
                        <h3 class="font-bold text-slate-900 mt-1 leading-snug">{{ $berita->judul }}</h3>
                        <p class="text-xs text-slate-400 mt-2">{{ $berita->tanggal_publikasi?->format('d M Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- CTA -->
    <div class="bg-[#0B2D4A] p-8 md:p-10 mt-8 text-center text-white">
        <h2 class="text-2xl md:text-3xl font-bold mb-3">Tertarik bergabung dengan {{ $ukm->nama }}?</h2>
        <p class="text-slate-300 mb-6 max-w-xl mx-auto">Daftarkan dirimu dan kembangkan potensimu bersama kami. Proses pendaftaran mudah dan cepat.</p>
        @auth
            @if(!auth()->user()->isAdmin())
                @php
                    $isAcceptedHere = $state && in_array($ukm->id, $state['acceptedUkmIds']);
                    $isRejectedHere = $state && in_array($ukm->id, $state['rejectedUkmIds']);
                @endphp
                @if($isAcceptedHere)
                    <span class="inline-block px-8 py-3 bg-[#1A4D3E] text-white font-bold">
                        ✓ Anda adalah Anggota
                    </span>
                @elseif($isRejectedHere)
                    <span class="inline-block px-8 py-3 bg-[#B91C1C] text-white font-bold">
                        ✗ Pendaftaran Anda Ditolak
                    </span>
                @elseif($state && ($state['hasPending'] || $state['hasAccepted']))
                    <span class="inline-block px-8 py-3 bg-white/20 text-white/80 font-semibold cursor-not-allowed">
                        Pendaftaran Ditutup
                    </span>
                @else
<a href="{{ route('daftar.create', $ukm) }}" class="inline-block px-8 py-3 bg-[#B8952E] text-white font-semibold hover:bg-[#CBA83A] transition-colors">
                        Daftar Sekarang
                    </a>
                @endif
            @else
                <a href="{{ route('admin.dashboard') }}" class="inline-block px-8 py-3 bg-white text-[#0B2D4A] font-semibold hover:bg-slate-100 transition-colors">
                    Dashboard Admin
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-[#B8952E] text-white font-semibold hover:bg-[#CBA83A] transition-colors">
                Daftar Sekarang
            </a>
        @endauth
    </div>
</div>
@endsection

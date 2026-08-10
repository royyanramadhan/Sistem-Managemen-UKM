@extends('layouts.public')

@section('title', 'Daftar UKM')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Daftar UKM</h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">Pilih unit kegiatan mahasiswa yang sesuai minatmu, lalu klik "Daftar" untuk mengisi formulir pendaftaran.</p>
    </div>

    <!-- Status pendaftaran saya -->
    @if($myRegistrations->count() > 0)
        <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-900">Status Pendaftaran Saya</h2>
<a href="{{ route('pendaftaran.status') }}" class="text-sm text-orange-600 font-semibold hover:text-orange-700">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">UKM</th>
                            <th class="px-4 py-3">Tanggal Daftar</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($myRegistrations as $reg)
                            <tr>
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $reg->ukm->nama }}</td>
                                <td class="px-4 py-3">{{ $reg->tanggal_daftar ? $reg->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($reg->status === 'diterima')
                                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-none text-xs font-bold">✓ Diterima</span>
                                    @elseif($reg->status === 'pending')
                                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-none text-xs font-bold">⏳ Menunggu</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-none text-xs font-bold">✗ Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <span class="text-slate-400 text-sm">-</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Banner status yang membatasi pendaftaran -->
    @if($state && $state['hasPending'])
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-none mb-8 flex items-start gap-3">
            <span class="text-xl">⏳</span>
            <div>
                <p class="font-bold">Pendaftaran Anda masih diproses</p>
                <p class="text-sm mt-0.5">Anda memiliki pendaftaran pada <strong>{{ $state['pendingRegistration']->ukm->nama }}</strong> yang sedang menunggu verifikasi admin. Tombol pendaftaran UKM lain dinonaktifkan hingga pendaftaran Anda diproses.</p>
            </div>
        </div>
    @elseif($state && $state['hasAccepted'])
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-none mb-8 flex items-start gap-3">
            <span class="text-xl">✓</span>
            <div>
                <p class="font-bold">Anda sudah menjadi anggota UKM</p>
                <p class="text-sm mt-0.5">Anda telah diterima sebagai anggota <strong>{{ $state['acceptedRegistration']->ukm->nama }}</strong>. Pendaftaran ke UKM lain ditutup.</p>
            </div>
        </div>
    @endif

    <!-- Daftar UKM yang bisa didaftar -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($ukms as $ukm)
            @php
                $myReg = $myRegistrations->firstWhere('ukm_id', $ukm->id);
                $isRejected = $state && in_array($ukm->id, $state['rejectedUkmIds']);
                $isAccepted = $state && in_array($ukm->id, $state['acceptedUkmIds']);
                $daftarDisabled = $state && ($state['hasPending'] || $state['hasAccepted']);
            @endphp
<div class="bg-white rounded-none shadow-sm border border-slate-100 hover:shadow-xl hover:border-orange-100 transition-all duration-300 overflow-hidden flex flex-col">
                <div class="p-6 flex-grow">
                    <div class="flex items-center gap-4 mb-4">
                        @if($ukm->logo)
                            <img src="{{ asset('storage/' . $ukm->logo) }}" class="w-16 h-16 object-cover rounded-none border border-slate-100">
                        @else
<div class="w-16 h-16 bg-orange-50 rounded-none flex items-center justify-center text-3xl">🏛️</div>
                        @endif
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $ukm->nama }}</h3>
<span class="bg-orange-50 text-orange-700 text-xs px-2.5 py-0.5 rounded-none font-semibold">{{ $ukm->bidang }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4">{{ $ukm->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    <p class="text-xs text-slate-400 font-medium">{{ $ukm->keanggotaans_count ?? 0 }} pendaftar</p>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 space-y-2">
                    <!-- Lihat Detail -->
<a href="{{ route('ukm.public.show', $ukm) }}" class="block border border-orange-200 text-orange-600 hover:bg-orange-50 text-center py-2 rounded-none text-sm font-semibold transition">
                        Lihat Detail
                    </a>

                    <!-- Tombol Daftar sesuai status -->
                    @if($isAccepted)
                        <span class="block bg-emerald-100 text-emerald-700 text-center py-2 rounded-none text-sm font-bold">✓ Anda adalah Anggota</span>
                    @elseif($isRejected)
                        <span class="block bg-red-100 text-red-700 text-center py-2 rounded-none text-sm font-bold">✗ Ditolak</span>
                    @elseif($daftarDisabled)
                        <span class="block bg-slate-100 text-slate-400 text-center py-2 rounded-none text-sm font-semibold cursor-not-allowed">Pendaftaran Ditutup</span>
                    @else
<a href="{{ route('daftar.create', $ukm) }}" class="block bg-orange-600 hover:bg-orange-700 text-white text-center py-2 rounded-none text-sm font-semibold transition">
                            Daftar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-slate-500">Belum ada UKM aktif yang tersedia.</div>
        @endforelse
    </div>
</div>
@endsection

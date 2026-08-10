 @extends('layouts.public')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-3">Status Pendaftaran</h1>
        <p class="text-lg text-slate-600">Pantau status permohonan pendaftaran UKM Anda di sini.</p>
    </div>

    @if(session('link_pendaftaran'))
        <div class="bg-orange-50 border border-orange-200 rounded-none p-6 mb-8 text-center">
            <p class="text-orange-800 font-semibold mb-1">📋 Satu langkah lagi!</p>
            <p class="text-sm text-orange-700 mb-4">
                Untuk menyelesaikan proses pendaftaran, silakan ikuti link formulir berikut, lalu isi sesuai data yang sudah Anda kirim tadi.
            </p>
            <a href="{{ session('link_pendaftaran') }}" target="_blank" rel="noopener"
                class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700 transition">
                Buka Formulir Pendaftaran ↗
            </a>
        </div>
    @endif

    

    @if($registrations->isEmpty())
        <div class="bg-white rounded-none shadow-sm border border-slate-100 p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-none bg-slate-100 text-slate-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada pendaftaran</h3>
            <p class="text-slate-500 mb-6">Anda belum mendaftar ke UKM mana pun.</p>
            <a href="{{ route('daftar.index') }}" class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700 transition">
                Daftar UKM Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($registrations as $reg)
                <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-shrink-0">
                        @if($reg->ukm->logo)
                            <img src="{{ asset('storage/' . $reg->ukm->logo) }}" class="w-14 h-14 object-cover rounded-none border border-slate-100">
                        @else
                            <div class="w-14 h-14 bg-orange-50 rounded-none flex items-center justify-center text-2xl">🏛️</div>
                        @endif
                    </div>
<div class="flex-1">
                        <h3 class="font-bold text-slate-900">{{ $reg->ukm->nama }}</h3>
                        <p class="text-sm text-slate-500">Didaftarkan pada {{ $reg->tanggal_daftar ? $reg->tanggal_daftar->format('d F Y') : '-' }}</p>
                        @if(in_array($reg->status, ['diterima', 'ditolak']))
                            <p class="text-sm text-slate-500">Diproses pada {{ $reg->updated_at ? $reg->updated_at->format('d F Y') : '-' }}</p>
                        @endif
                        @if($reg->status === 'ditolak' && $reg->alasan_penolakan)
                            <p class="text-sm text-red-600 mt-1">Alasan penolakan: {{ $reg->alasan_penolakan }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        @if($reg->status === 'diterima')
                            <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-none text-sm font-bold">✓ Diterima</span>
                        @elseif($reg->status === 'pending')
                            <span class="bg-amber-100 text-amber-700 px-4 py-2 rounded-none text-sm font-bold">⏳ Menunggu</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-none text-sm font-bold">✗ Ditolak</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('daftar.index') }}" class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700 transition">
                Daftar UKM Lainnya
            </a>
        </div>
    @endif
</div>
@endsection

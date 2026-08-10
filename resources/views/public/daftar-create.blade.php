@extends('layouts.public')

@section('title', 'Daftar ' . $ukm->nama)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back -->
<a href="{{ route('daftar.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-orange-600 font-medium mb-8 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar UKM
    </a>

    <!-- UKM Header -->
    <div class="bg-white rounded-none shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-[#D97706] to-[#F97316] h-24"></div>
        <div class="px-6 md:px-8 pb-6">
            <div class="flex flex-col md:flex-row items-start md:items-end gap-5 -mt-10">
                <div class="flex-shrink-0">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/' . $ukm->logo) }}" class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-none border-4 border-white shadow-md bg-white">
                    @else
                        <div class="w-20 h-20 md:w-24 md:h-24 bg-slate-100 rounded-none border-4 border-white shadow-md flex items-center justify-center text-4xl">🏛️</div>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $ukm->nama }}</h1>
@if($ukm->bidang)
                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-none text-xs font-semibold">{{ $ukm->bidang }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah terdaftar / diblokir (safety, biasanya sudah di-redirect oleh controller) -->
    @if($existing && $existing->status === 'diterima')
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-none mb-6">
            Anda sudah terdaftar sebagai anggota <strong>{{ $ukm->nama }}</strong>.
        </div>
        <div class="text-center py-8">
<a href="{{ route('daftar.index') }}" class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700">Kembali ke Daftar UKM</a>
        </div>
    @elseif($existing && $existing->status === 'pending')
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-none mb-6">
            Permohonan Anda untuk <strong>{{ $ukm->nama }}</strong> sedang menunggu persetujuan admin.
        </div>
        <div class="text-center py-8">
<a href="{{ route('pendaftaran.status') }}" class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700">Lihat Status Pendaftaran</a>
        </div>
    @elseif($existing && $existing->status === 'ditolak')
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-none mb-6">
            <p class="font-bold">Permohonan Anda untuk UKM ini telah ditolak.</p>
            @if($existing->alasan_penolakan)
                <p class="mt-1">Alasan: {{ $existing->alasan_penolakan }}</p>
            @endif
            <p class="mt-1">Sesuai aturan, Anda tidak dapat mendaftar kembali ke UKM ini.</p>
        </div>
        <div class="text-center py-8">
<a href="{{ route('daftar.index') }}" class="inline-block px-6 py-2.5 bg-orange-600 text-white rounded-none text-sm font-semibold hover:bg-orange-700">Kembali ke Daftar UKM</a>
        </div>
    @else
        <!-- Form -->
        <div class="bg-white rounded-none shadow-sm border border-slate-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Formulir Pendaftaran</h2>

            <form action="{{ route('daftar.store') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ukm_id" value="{{ $ukm->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-none bg-slate-50 text-sm text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">NIM</label>
                        <input type="text" value="{{ auth()->user()->nim }}" readonly
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-none bg-slate-50 text-sm text-slate-600">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" readonly
                        class="w-full px-3 py-2.5 border border-slate-200 rounded-none bg-slate-50 text-sm text-slate-600">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->telepon) }}"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-none focus:ring-2 focus:ring-orange-500 outline-none text-sm"
                        placeholder="Contoh: 081234567890" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                        <input type="text" name="fakultas" value="{{ old('fakultas', auth()->user()->fakultas) }}"
                            class="w-full px-3 py-2.5 border border-slate-300 rounded-none focus:ring-2 focus:ring-orange-500 outline-none text-sm"
                            placeholder="Contoh: Teknik" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
                        <input type="text" name="program_studi" value="{{ old('program_studi', auth()->user()->program_studi) }}"
                            class="w-full px-3 py-2.5 border border-slate-300 rounded-none focus:ring-2 focus:ring-orange-500 outline-none text-sm"
                            placeholder="Contoh: Teknik Informatika" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Angkatan <span class="text-red-500">*</span></label>
                        <input type="text" name="angkatan" value="{{ old('angkatan', auth()->user()->angkatan) }}"
                            class="w-full px-3 py-2.5 border border-slate-300 rounded-none focus:ring-2 focus:ring-orange-500 outline-none text-sm"
                            placeholder="Contoh: 2024" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Alasan bergabung <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan" rows="3" required
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-none focus:ring-2 focus:ring-orange-500 outline-none text-sm"
                        placeholder="Tuliskan alasan Anda...">{{ old('alasan') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Upload KTM (opsional, JPG maks 3MB)</label>
                    <input type="file" name="ktm" accept=".jpg,.jpeg"
                        class="w-full px-3 py-2.5 border border-slate-300 rounded-none text-sm">
                </div>

                <label class="flex items-start gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="persetujuan" id="persetujuan" required
class="mt-1 w-4 h-4 text-orange-600 border-slate-300 rounded-none focus:ring-orange-500">
                    <span>Dengan mengirim permohonan, saya menyetujui bahwa data yang saya isi adalah benar dan saya bersedia mematuhi peraturan UKM.</span>
                </label>

<button type="submit" id="submit-btn" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3 rounded-none text-sm font-semibold transition shadow-lg shadow-orange-200">
                    📨 Kirim Permohonan
                </button>
            </form>
        </div>
    @endif
</div>

<script>
    // Cegah submit ganda saat form dikirim
    document.querySelector('form[action="{{ route('daftar.store') }}"]')?.addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Mengirim...';
        }
    });
</script>
@endsection

@extends('layouts.public')

@section('title', 'Profil Saya')

@section('content')
<div class="portal-container py-10 lg:py-12 space-y-6">

    <div>
        <p class="portal-section-label">Akun</p>
        <h1 class="portal-section-title">Profil Saya</h1>
    </div>

    {{-- Profile header --}}
    <div class="portal-card overflow-hidden">
        <div class="portal-profile-banner"></div>
        <div class="px-6 pb-6">
            <div class="flex items-end gap-5 -mt-12">
                <div class="portal-profile-avatar flex items-center justify-center text-2xl font-bold text-[#0B2D4A] overflow-hidden shrink-0">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="pb-1">
                    <h2 class="text-xl font-bold text-[#0F172A]">{{ $user->name }}</h2>
                    <p class="text-[#64748B] text-sm">{{ $user->email }}</p>
                    <p class="text-[#64748B] text-sm">NIM: {{ $user->nim }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Profile Form --}}
    <div class="portal-card portal-card-body">
        <h3 class="text-lg font-bold text-[#0B2D4A] mb-5">Edit Profil</h3>
        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="portal-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="portal-input" required>
            </div>

            <div>
                <label class="portal-label">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->telepon) }}" class="portal-input" placeholder="Contoh: 081234567890">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="portal-label">Fakultas</label>
                    <input type="text" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}" class="portal-input">
                </div>
                <div>
                    <label class="portal-label">Program Studi</label>
                    <input type="text" name="program_studi" value="{{ old('program_studi', $user->program_studi) }}" class="portal-input">
                </div>
                <div>
                    <label class="portal-label">Angkatan</label>
                    <input type="text" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}" class="portal-input">
                </div>
            </div>

            <div>
                <label class="portal-label">Foto Profil <span class="normal-case font-normal text-[#64748B]">(opsional, maks 2MB)</span></label>
                <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="portal-input">
            </div>

            <button type="submit" class="portal-btn portal-btn-primary w-full py-3">Simpan Profil</button>
        </form>
    </div>

    <div class="portal-alert portal-alert-info">
        Untuk mengubah password, silakan hubungi admin.
    </div>
</div>
@endsection

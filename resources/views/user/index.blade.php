@extends('layouts.app')

@section('title', 'Data Anggota')

@section('breadcrumb', 'Data Anggota')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="portal-page-header">
        <div>
            <h1 class="portal-page-title">Data Anggota</h1>
            <p class="portal-page-subtitle">Anggota berasal dari pendaftaran UKM yang telah disetujui.</p>
        </div>
        <span class="portal-badge portal-badge-navy text-sm font-bold px-3 py-1.5">
            {{ $members->count() }} Anggota Aktif
        </span>
    </div>

    <!-- Search & Filter Bar -->
    <div class="portal-card p-4">
        <form action="{{ route('user.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." class="portal-input pl-9">
                </div>
            </div>
            <div>
                <select name="ukm" class="portal-select">
                    <option value="">Semua UKM</option>
                    @foreach($ukms as $ukm)
                        <option value="{{ $ukm->id }}" {{ request('ukm') == $ukm->id ? 'selected' : '' }}>{{ $ukm->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="jabatan" class="portal-select">
                    <option value="">Semua Jabatan</option>
                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ request('jabatan') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="portal-btn portal-btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if(request('search') || request('ukm') || request('jabatan'))
                    <a href="{{ route('user.index') }}" class="portal-btn portal-btn-ghost">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="portal-card overflow-hidden">
        @if($members->isEmpty())
            <div class="portal-empty">
                <div class="portal-empty-icon text-5xl">👥</div>
                <h3 class="portal-empty-title">Tidak Ada Data Anggota</h3>
                <p class="portal-empty-text">Belum ada anggota yang sesuai dengan filter pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>UKM</th>
                            <th>Jabatan</th>
                            <th>Tanggal Bergabung</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($members as $member)
                            <tr>
                                <td>
                                    @if($member->user->photo)
                                        <img src="{{ asset('storage/' . $member->user->photo) }}" class="w-10 h-10 object-cover border border-[#E2E8F0]">
                                    @else
                                        <div class="w-10 h-10 bg-[#E8EEF4] text-[#0B2D4A] flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($member->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="font-semibold text-slate-800">{{ $member->user->name }}</td>
                                <td>{{ $member->user->nim }}</td>
                                <td>
                                    <span class="portal-badge">{{ $member->ukm->nama }}</span>
                                </td>
                                <td>
                                    @php
                                        $jabatanLabel = $member->jabatan->nama;
                                        if ($jabatanLabel === 'Kepala Divisi' && $member->divisi) {
                                            $jabatanLabel = 'Kepala Divisi ' . $member->divisi->nama;
                                        }
                                    @endphp
                                    <span class="portal-badge portal-badge-navy">{{ $jabatanLabel }}</span>
                                </td>
                                <td>{{ $member->tanggal_mulai ? $member->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                                <td class="text-center">
                                    @include('partials._status-badge', ['status' => $member->status])
                                </td>
                                <td>
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('user.show', $member) }}" class="portal-btn portal-btn-secondary text-xs px-2.5 py-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                        <button onclick="openJabatanModal({{ $member->id }}, '{{ addslashes($member->jabatan->nama) }}')" class="portal-btn portal-btn-ghost text-xs px-2.5 py-1.5" style="border-color: #B8952E; color: #7A6020; background: #F5EFE0;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Jabatan
                                        </button>
                                        <button onclick="openStatusModal({{ $member->id }}, '{{ $member->status }}')" class="portal-btn portal-btn-ghost text-xs px-2.5 py-1.5" style="border-color: #A8C5B9; color: #1A4D3E; background: #E6F0EC;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Status
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal Ubah Jabatan -->
<div id="jabatan-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white border border-[#C8D1DC] w-full max-w-sm p-6 shadow-xl">
        <h3 class="text-xl font-bold text-[#0B2D4A] mb-4">Ubah Jabatan</h3>
        <form id="jabatan-form" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="portal-label">Jabatan</label>
                <select name="jabatan_id" id="jabatan-select" class="portal-select">
                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeModal('jabatan-modal')" class="portal-btn portal-btn-secondary flex-1">Batal</button>
                <button type="submit" class="portal-btn portal-btn-gold flex-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ubah Status -->
<div id="status-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white border border-[#C8D1DC] w-full max-w-sm p-6 shadow-xl">
        <h3 class="text-xl font-bold text-[#0B2D4A] mb-4">Ubah Status Anggota</h3>
        <form id="status-form" action="" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="portal-label">Status Keanggotaan</label>
                <select name="status" id="status-select" class="portal-select">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <p class="text-xs text-slate-500">Mengubah status menjadi Nonaktif tidak menghapus data anggota. Data & riwayat tetap tersimpan.</p>
            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeModal('status-modal')" class="portal-btn portal-btn-secondary flex-1">Batal</button>
                <button type="submit" class="portal-btn portal-btn-green flex-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const jabatans = @json($jabatans->map(fn($j) => ['id' => $j->id, 'nama' => $j->nama]));

    function openJabatanModal(memberId, currentJabatan) {
        const form = document.getElementById('jabatan-form');
        form.action = "{{ url('user/member') }}/" + memberId + "/jabatan";
        const select = document.getElementById('jabatan-select');
        const current = jabatans.find(j => j.nama === currentJabatan);
        if (current) {
            select.value = current.id;
        }
        document.getElementById('jabatan-modal').classList.remove('hidden');
    }

    function openStatusModal(memberId, currentStatus) {
        const form = document.getElementById('status-form');
        form.action = "{{ url('user/member') }}/" + memberId + "/status";
        document.getElementById('status-select').value = currentStatus;
        document.getElementById('status-modal').classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection

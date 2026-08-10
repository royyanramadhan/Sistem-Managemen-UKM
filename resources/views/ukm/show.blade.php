@extends('layouts.app')

@section('title', $ukm->nama)

@section('content')
<div class="space-y-8">
    <!-- Back Button (top-left, beautified) -->
    <div class="flex items-center justify-between">
        <a href="{{ route('ukm.index') }}" class="portal-btn portal-btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar UKM
        </a>
    </div>

<!-- Header Section -->
    <div class="card overflow-hidden">
        <!-- Banner Biru -->
        <div class="bg-[#0B2D4A] h-36 w-full relative"><div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 1px, transparent 1px, transparent 12px);"></div></div>

        <div class="px-6 md:px-8 pb-8">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 -mt-16 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
                    <!-- Logo -->
                    <div class="flex-shrink-0 z-10">
                        @if($ukm->logo)
                            <img src="{{ asset('storage/' . $ukm->logo) }}" alt="{{ $ukm->nama }}" class="w-32 h-32 md:w-36 md:h-36 object-cover border-4 border-white bg-white">
                        @else
                            <div class="w-32 h-32 md:w-36 md:h-36 bg-[#EEF1F5] border-4 border-white flex items-center justify-center text-5xl">🏛️</div>
                        @endif
                    </div>

                    <!-- Title & Badges -->
                    <div class="pt-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">{{ $ukm->nama }}</h1>
                            <span class="portal-badge portal-badge-navy">{{ $ukm->bidang }}</span>
                            @include('partials._status-badge', ['status' => $ukm->status])
                        </div>
                        <p class="text-slate-600 mt-2 text-base md:text-lg">{{ $ukm->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex-shrink-0 w-full md:w-auto flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('ukm.edit', $ukm) }}" class="btn btn-indigo">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit UKM
                    </a>
                    <button type="button" onclick="openDivisiModal()" class="btn btn-ghost">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                        Kelola Divisi
                    </button>
                </div>
            </div>

            <!-- Stats / Contact Info -->
            <div class="mt-6 pt-6 border-t border-[#E2E8F0] grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#FAFBFC] p-4 border border-[#E2E8F0]">
                    <p class="text-slate-500 text-xs font-medium">📧 Email</p>
                    <p class="font-semibold text-slate-800 text-sm mt-1 truncate">{{ $ukm->email ?? '-' }}</p>
                </div>
                <div class="bg-[#FAFBFC] p-4 border border-[#E2E8F0]">
                    <p class="text-slate-500 text-xs font-medium">📱 Telepon</p>
                    <p class="font-semibold text-slate-800 text-sm mt-1">{{ $ukm->telepon ?? '-' }}</p>
                </div>
                <div class="bg-[#FAFBFC] p-4 border border-[#E2E8F0]">
                    <p class="text-slate-500 text-xs font-medium">📍 Lokasi</p>
                    <p class="font-semibold text-slate-800 text-sm mt-1 line-clamp-1">{{ $ukm->alamat ?? '-' }}</p>
                </div>
                <div class="bg-[#E8EEF4] p-4 border border-[#B5C6D7]">
                    <p class="text-[#0B2D4A] text-xs font-medium">👥 Anggota</p>
                    <p class="font-bold text-[#0B2D4A] text-lg mt-1">{{ $ukm->kepengurusans->count() }} Orang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Org Chart Section -->
    <div class="portal-card p-6 md:p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Struktur Organisasi</h2>
            <button type="button" onclick="openModal()" class="portal-btn portal-btn-green text-sm">
                <span>➕</span> Tambah Anggota
            </button>
        </div>

@if($ukm->kepengurusans->count() > 0)
            @php
                // Kelompokkan kepengurusan berdasarkan nama jabatan.
                // Sekarang TIDAK memfilter Kepala Divisi / Sekretaris Divisi lagi.
                $kepengurusans = $ukm->kepengurusans->filter(fn($k) => in_array($k->jabatan->nama, [
                    'Ketua Umum','Wakil Ketua','Sekretaris Umum','Bendahara',
                    'Kepala Divisi','Sekretaris Divisi','Anggota'
                ]));
                $ketua = $kepengurusans->first(fn($k) => $k->jabatan->nama === 'Ketua Umum');
                $wakil = $kepengurusans->first(fn($k) => $k->jabatan->nama === 'Wakil Ketua');
                $sekretaris = $kepengurusans->first(fn($k) => $k->jabatan->nama === 'Sekretaris Umum');
                $bendahara = $kepengurusans->first(fn($k) => $k->jabatan->nama === 'Bendahara');
            @endphp

<div class="tf-tree" style="overflow-x: auto; padding-top: 10px;">
    <ul>
        <li>
            {{-- KETUA --}}
            <div class="tf-nc" style="padding: 0; border: none; background: transparent; min-width: auto;">
                @if($ketua)
                    @include('ukm.partials._org-card', ['member' => $ketua])
                @else
                    @include('ukm.partials._org-empty-card', ['jabatanName' => 'Ketua Umum'])
                @endif
            </div>

            <ul>
                {{-- WAKIL KETUA --}}
                <li>
                    <div class="tf-nc" style="padding: 0; border: none; background: transparent; min-width: auto;">
                        @if($wakil)
                            @include('ukm.partials._org-card', ['member' => $wakil])
                        @else
                            @include('ukm.partials._org-empty-card', ['jabatanName' => 'Wakil Ketua'])
                        @endif
                    </div>

                    <ul>
                        {{-- SEKRETARIS & BENDAHARA --}}
                        <li>
                            <div class="tf-nc" style="padding: 0; border: none; background: transparent; min-width: auto;">
                                @if($sekretaris)
                                    @include('ukm.partials._org-card', ['member' => $sekretaris])
                                @else
                                    @include('ukm.partials._org-empty-card', ['jabatanName' => 'Sekretaris Umum'])
                                @endif
                            </div>
                        </li>
                        <li>
                            <div class="tf-nc" style="padding: 0; border: none; background: transparent; min-width: auto;">
                                @if($bendahara)
                                    @include('ukm.partials._org-card', ['member' => $bendahara])
                                @else
                                    @include('ukm.partials._org-empty-card', ['jabatanName' => 'Bendahara'])
                                @endif
                            </div>
                        </li>

                        {{-- DIVISI --}}
                        @if($divisis->count() > 0)
                            @foreach($divisis as $divisi)
                                @php
                                    $kepalaDivisi = $ukm->kepengurusans->first(fn($k) => $k->jabatan->nama === 'Kepala Divisi' && $k->divisi_id === $divisi->id);
                                    $anggotaDivisi = $ukm->kepengurusans->filter(fn($k) => $k->divisi_id === $divisi->id && in_array($k->jabatan->nama, ['Sekretaris Divisi', 'Anggota']));
                                @endphp
                                <li>
                                    <div class="tf-nc" style="padding: 0; border: none; background: transparent; min-width: auto;">
                                        @if($kepalaDivisi)
                                            @include('ukm.partials._org-card', ['member' => $kepalaDivisi])
                                        @else
                                            @include('ukm.partials._org-empty-card', [
                                                'jabatanName' => 'Kepala Divisi',
                                                'divisiNama' => $divisi->nama,
                                                'jabatanId' => \App\Models\Jabatan::where('nama','Kepala Divisi')->value('id'),
                                                'divisiId' => $divisi->id,
                                            ])
                                        @endif
                                    </div>

                                    @if($anggotaDivisi->count() > 0)
                                        <ul>
                                            @foreach($anggotaDivisi as $orgAnggota)
                                                <li>
                                                    <div class="tf-nc" style="cursor: pointer;" onclick="openEditSlot({{ $orgAnggota->id }}, {{ $orgAnggota->jabatan_id }}, {{ $orgAnggota->divisi_id ?? 'null' }})">
                                                        <div class="tf-nc-name" style="font-size: 0.8rem; white-space: nowrap;">{{ $orgAnggota->user->name }}</div>
                                                        @if($orgAnggota->jabatan->nama === 'Sekretaris Divisi')
                                                            <div class="tf-nc-name" style="font-size: 0.7rem; color: #64748B;">Sekretaris Divisi</div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
        @else
            <div class="text-center py-12 bg-[#F8FAFC] border border-dashed border-[#C8D1DC]">
                <p class="text-gray-500 text-base">Belum ada anggota di UKM ini.</p>
                <button type="button" onclick="openModal()" class="mt-2 text-blue-600 hover:underline font-semibold text-sm">
                    + Tambahkan Anggota Pertama
                </button>
            </div>
        @endif
    </div>

    <!-- Section Prestasi -->
    <div class="portal-card p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">🏆 Prestasi UKM</h2>
            <button type="button" onclick="openPrestasiModal()" class="portal-btn portal-btn-gold text-sm">
                <span>➕</span> Tambah Prestasi
            </button>
        </div>

        @if($ukm->prestasis && $ukm->prestasis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ukm->prestasis as $prestasi)
                    <div class="border border-[#D9C486] bg-[#FFFBEB] p-5 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-amber-900 text-lg">{{ $prestasi->nama_prestasi }}</h3>
                                <span class="portal-badge portal-badge-gold">{{ $prestasi->tingkat }}</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">{{ $prestasi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <div class="pt-3 border-t border-amber-200 text-xs text-amber-700 flex justify-between items-center">
                            <span>📅 {{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '-' }}</span>
                            <form action="{{ route('prestasi.destroy', $prestasi) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-[#F8FAFC] border border-dashed border-[#C8D1DC]">
                <p class="text-gray-500 text-sm">Belum ada data prestasi untuk UKM ini.</p>
            </div>
        @endif
    </div>

    <!-- Section Kegiatan -->
    <div class="portal-card p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">📅 Kegiatan UKM</h2>
            <button type="button" onclick="openKegiatanModal()" class="portal-btn portal-btn-primary text-sm">
                <span>➕</span> Tambah Kegiatan
            </button>
        </div>

        @if($ukm->kegiatans && $ukm->kegiatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ukm->kegiatans as $kegiatan)
                    <div class="border border-[#B5C6D7] bg-[#EEF4FB] p-5 flex flex-col justify-between">
<div>
                            <h3 class="font-bold text-indigo-900 text-lg mb-2">{{ $kegiatan->nama }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <div class="pt-3 border-t border-indigo-200 text-xs text-indigo-700 flex justify-between items-center">
                            <span>📍 {{ $kegiatan->tempat ?? '-' }}</span>
                            <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-[#F8FAFC] border border-dashed border-[#C8D1DC]">
                <p class="text-gray-500 text-sm">Belum ada data kegiatan untuk UKM ini.</p>
            </div>
        @endif
    </div>

    <!-- Section Daftar Anggota -->
    <div class="portal-card p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">👥 Daftar Anggota</h2>
            <span class="portal-badge portal-badge-navy">{{ $anggota->count() }} Anggota Disetujui</span>
        </div>

        @if($anggota->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIM</th>
                            <th class="px-4 py-2">Program Studi</th>
                            <th class="px-4 py-2">Jabatan Saat Ini</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($anggota as $index => $angg)
                            @php
                                $currentJabatan = $pengurusAktif[$angg->user->id] ?? null;
                            @endphp
                            <tr>
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-semibold text-gray-800">{{ $angg->user->name }}</td>
                                <td class="px-4 py-2">{{ $angg->user->nim }}</td>
                                <td class="px-4 py-2">{{ $angg->user->program_studi ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if($currentJabatan)
                                        <span class="portal-badge portal-badge-green inline-flex items-center gap-1">
                                            {{ $currentJabatan }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Belum menjadi pengurus</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <button type="button" onclick="openModalForMember({{ $angg->user->id }}, '{{ addslashes($angg->user->name) }}')"
                                        class="portal-btn portal-btn-primary text-xs px-3 py-1.5">
                                        🎖️ Jadikan Pengurus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 bg-[#F8FAFC] border border-dashed border-[#C8D1DC]">
                <p class="text-gray-500 text-sm">Belum ada anggota yang disetujui di UKM ini.</p>
            </div>
        @endif
    </div>

    <!-- Back Button -->
    <div class="pt-2">
        <a href="{{ route('ukm.index') }}" class="portal-btn portal-btn-secondary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke daftar UKM
        </a>
    </div>
</div>

<!-- Modal Konfirmasi Ganti Jabatan -->
<div id="confirmReplaceModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[60] p-4">
    <div class="bg-white border border-[#C8D1DC] shadow-2xl p-6 md:p-8 max-w-md w-full">
        <div class="flex items-start gap-4 mb-4">
            <div class="flex-shrink-0 w-11 h-11 bg-[#F5EFE0] text-[#B8952E] flex items-center justify-center text-xl">⚠️</div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Ganti Jabatan Pengurus?</h3>
                <p class="text-sm text-gray-600" id="confirm_move_text">Mahasiswa ini sudah menjabat.</p>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="button" id="btnCancelReplace" onclick="cancelReplace()" class="portal-btn portal-btn-secondary flex-1">Batal</button>
            <button type="button" id="btnConfirmReplace" onclick="doReplace()" class="portal-btn portal-btn-gold flex-1">Ganti</button>
        </div>
    </div>
</div>

<!-- Modal Tambah Anggota -->
<div id="addMemberModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4" onclick="if(event.target.id === 'addMemberModal') closeModal()">
    <div class="bg-white border border-[#C8D1DC] shadow-2xl p-6 md:p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-[#0B2D4A]">Tambah Anggota</h3>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
        </div>
        
<form action="{{ route('kepengurusan.store', $ukm) }}" method="POST" class="space-y-4" id="pengurusForm">
            @csrf
            <input type="hidden" name="user_id" id="selected_user_id">
            <input type="hidden" name="replace_existing" id="replace_existing" value="0">
            <input type="hidden" name="edit_kepengurusan_id" id="edit_kepengurusan_id" value="">
            <input type="hidden" name="slot_jabatan_id" id="slot_jabatan_id" value="">
            <input type="hidden" name="slot_divisi_id" id="slot_divisi_id" value="">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Anggota</label>
                <select id="anggota_select" class="portal-select" required>
                    <option value="">-- Pilih Anggota (ketik Nama atau NIM) --</option>
                    @foreach($anggota as $angg)
                        <option value="{{ $angg->user->id }}">{{ $angg->user->name }} — {{ $angg->user->nim }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Hanya menampilkan anggota yang sudah disetujui (diterima) di UKM ini.</p>
            </div>
<div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Jabatan</label>
                <select name="jabatan_id" class="portal-select" required>
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div id="divisi_field">
                <label class="portal-label">Jabatan <span class="text-red-500">*</span></label>(opsional, untuk jabatan Anggota)</span></label>
                <select name="divisi_id" class="portal-select">
                    <option value="">-- Pilih Divisi --</option>
                    @foreach($divisis as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="portal-label">Anggota Baru</label>
                <input type="date" name="tanggal_mulai" class="portal-input">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="portal-btn portal-btn-secondary flex-1">Batal</button>
                <button type="submit" class="portal-btn portal-btn-green flex-1">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Prestasi -->
<div id="addPrestasiModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4" onclick="if(event.target.id === 'addPrestasiModal') closePrestasiModal()">
    <div class="bg-white rounded-none shadow-2xl p-6 md:p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Tambah Prestasi</h3>
            <button type="button" onclick="closePrestasiModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
        </div>
        
        <form action="{{ route('prestasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="ukm_id" value="{{ $ukm->id }}">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" required class="portal-input" placeholder="Contoh: Juara 1 Lomba Debat Nasional">
<div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tingkat</label>
                <select name="tingkat" class="portal-select" required>
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="lokal">Lokal</option>
                    <option value="regional">Regional</option>
                    <option value="nasional">Nasional</option>
                    <option value="internasional">Internasional</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Rilis</label>
                <input type="date" name="tanggal_akhir" class="portal-input" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="portal-textarea"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Piagam (Gambar, Opsional)</label>
                <input type="file" name="piagam" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm bg-white">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white py-2 rounded-none font-semibold text-sm transition">✅ Simpan</button>
                <button type="button" onclick="closePrestasiModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-none font-semibold text-sm transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Kegiatan -->
<div id="addKegiatanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4" onclick="if(event.target.id === 'addKegiatanModal') closeKegiatanModal()">
    <div class="bg-white rounded-none shadow-2xl p-6 md:p-8 max-w-md w-full">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Tambah Kegiatan</h3>
            <button type="button" onclick="closeKegiatanModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
        </div>
        
        <form action="{{ route('kegiatan.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="ukm_id" value="{{ $ukm->id }}">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kegiatan</label>
                <input type="text" name="nama" required class="portal-input" placeholder="Contoh: Rapat Kerja Tahunan">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi" placeholder="Contoh: Aula Kampus, Zoom" class="w-full px-3 py-2 border border-gray-300 rounded-none focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="portal-textarea"></textarea>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-none font-semibold text-sm transition">✅ Simpan</button>
                <button type="button" onclick="closeKegiatanModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-none font-semibold text-sm transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Kelola Divisi -->
<div id="divisiModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[70] p-4" onclick="if(event.target.id === 'divisiModal') closeDivisiModal()">
    <div class="bg-white border border-[#C8D1DC] shadow-2xl p-6 md:p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">🗂️ Kelola Divisi — {{ $ukm->nama }}</h3>
            <button type="button" onclick="closeDivisiModal()" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
        </div>

        <!-- Form Tambah Divisi -->
        <form action="{{ route('divisi.store', $ukm) }}" method="POST" class="flex flex-col sm:flex-row gap-3 mb-6 p-4 bg-[#F8FAFC] border border-[#E2E8F0]">
            @csrf
            <input type="text" name="nama" placeholder="Nama divisi baru (contoh: Humas)" required class="portal-input flex-1">
            <select name="status" class="portal-select">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
            <button type="submit" class="portal-btn portal-btn-primary">Tambah</button>
        </form>

        <!-- Daftar Divisi -->
        @if($ukm->divisis->count() > 0)
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2">Nama Divisi</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($ukm->divisis as $divisi)
                        <tr>
                            <td class="px-4 py-2">
                                <form action="{{ route('divisi.update', [$ukm, $divisi]) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="nama" value="{{ $divisi->nama }}" class="flex-1 px-3 py-1.5 border border-gray-300 rounded-none focus:ring-2 focus:ring-amber-500 outline-none text-sm">
                                    <select name="status" class="px-2 py-1.5 border border-gray-300 rounded-none text-xs bg-white">
                                        <option value="aktif" {{ $divisi->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ $divisi->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-none text-xs font-medium transition">💾</button>
                                </form>
                            </td>
                            <td class="px-4 py-2">
                                @if($divisi->status === 'aktif')
                                    <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-none text-xs font-bold">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-none text-xs font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('divisi.destroy', [$ukm, $divisi]) }}" method="POST" onsubmit="return confirm('Hapus divisi ini? Anggota di dalamnya akan dikembalikan ke tanpa divisi.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-none text-xs font-medium transition">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-none border border-dashed border-gray-300">
                <p class="text-gray-500 text-sm">Belum ada divisi untuk UKM ini. Tambahkan divisi pertama di atas.</p>
            </div>
        @endif
    </div>
</div>

<script>
function openDivisiModal() {
    const modal = document.getElementById('divisiModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeDivisiModal() {
    const modal = document.getElementById('divisiModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openModal() {
    const modal = document.getElementById('addMemberModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeModal() {
    const modal = document.getElementById('addMemberModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openPrestasiModal() {
    const modal = document.getElementById('addPrestasiModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closePrestasiModal() {
    const modal = document.getElementById('addPrestasiModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function openKegiatanModal() {
    const modal = document.getElementById('addKegiatanModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeKegiatanModal() {
    const modal = document.getElementById('addKegiatanModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// ===== Buka modal untuk mengedit/mengisi sebuah SLOT (lingkaran) pada org chart =====
// Jika kepengurusanId ada → mode edit (ganti orang pada slot tsb).
// Jika tidak → mode isi slot kosong (jabatan & divisi diisi dari konteks slot).
function openEditSlot(kepengurusanId, jabatanId, divisiId) {
    // Reset form
    document.getElementById('edit_kepengurusan_id').value = kepengurusanId || '';
    document.getElementById('slot_jabatan_id').value = jabatanId || '';
    document.getElementById('slot_divisi_id').value = divisiId || '';
    document.getElementById('replace_existing').value = '0';

    // Prefill jabatan & divisi (locked) sesuai slot yang diklik
    const jab = document.querySelector('select[name="jabatan_id"]');
    if (jab && jabatanId) jab.value = jabatanId;
    const divsel = document.querySelector('select[name="divisi_id"]');
    if (divsel && divisiId) divsel.value = divisiId;

    // Header modal
    const title = document.querySelector('#addMemberModal h3');
    if (title) title.textContent = kepengurusanId ? 'Ganti Pengurus Slot' : 'Isi Slot Posisi';

    openModal();
}

// ===== Buka modal untuk mengisi slot KOSONG (dipanggil dari empty-card) =====
function openEmptyEditSlot(jabatanId, divisiId) {
    openEditSlot(null, jabatanId, divisiId);
}

// ===== Maps dari controller: pengurus aktif (user_id => jabatan) =====
// Dipakai untuk cek dobel jabatan sebelum submit
const pengurusAktif = @json($pengurusAktif);

// ===== Data sesi "Ganti" (dikirim server saat dobel jabatan terdeteksi tanpa konfirmasi) =====
// Dipakai untuk menampilkan modal konfirmasi lagi dgn nama jabatan asli
const confirmReplaceData = @json(session('confirm_replace'));

// ===== Inisialisasi Choices.js untuk dropdown anggota =====
let anggotaChoices = null;
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('anggota_select');
    if (el && window.Choices) {
        anggotaChoices = new Choices(el, {
            searchEnabled: true,
            searchPlaceholderValue: 'Ketik nama atau NIM...',
            placeholderValue: 'Pilih Anggota...',
            shouldSort: false,
            allowHTML: true,
            itemSelectText: 'Pilih',
            searchResultLimit: 20,
            noChoicesText: 'Tidak ada anggota yang cocok',
            noResultsText: 'Tidak ditemukan',
            classNames: {
                containerInner: 'choices w-full text-sm',
                item: 'choices__item',
            },
        });
    }
});

// Jika ada data sesi "Ganti" (dobel jabatan terdeteksi server tanpa konfirmasi),
// tampilkan kembali modal konfirmasi dgn nama jabatan asli & prefill form agar "Ganti" berfungsi.
if (confirmReplaceData && confirmReplaceData.user_id) {
    document.addEventListener('DOMContentLoaded', function () {
        // Set user_id terpilih (agar "Ganti" mengirim user_id yang benar)
        const sel = document.getElementById('anggota_select');
        if (anggotaChoices && sel) {
            anggotaChoices.setChoiceByValue(String(confirmReplaceData.user_id));
        }
        if (sel) {
            sel.value = confirmReplaceData.user_id;
            document.getElementById('selected_user_id').value = confirmReplaceData.user_id;
        }

        // Prefill jabatan & tanggal
        const jab = document.querySelector('select[name="jabatan_id"]');
        if (jab && confirmReplaceData.jabatan_id) {
            jab.value = confirmReplaceData.jabatan_id;
        }
        const tglMulai = document.querySelector('input[name="tanggal_mulai"]');
        if (tglMulai && confirmReplaceData.tanggal_mulai) {
            tglMulai.value = confirmReplaceData.tanggal_mulai;
        }
        const tglAkhir = document.querySelector('input[name="tanggal_akhir"]');
        if (tglAkhir && confirmReplaceData.tanggal_akhir) {
            tglAkhir.value = confirmReplaceData.tanggal_akhir;
        }

        // Tampilkan modal konfirmasi
        document.getElementById('confirm_move_text').textContent =
            'Mahasiswa ini sudah menjabat sebagai "' + confirmReplaceData.old_jabatan + '". Ganti ke "' +
            confirmReplaceData.new_jabatan + '"?';
        document.getElementById('confirmReplaceModal').classList.remove('hidden');
        document.getElementById('confirmReplaceModal').classList.add('flex');
    });
}

// ===== Ambil user_id dari pilihan Choices & salin ke hidden input =====
function syncSelectedUserId() {
    const el = document.getElementById('anggota_select');
    const hidden = document.getElementById('selected_user_id');
    if (!el || !hidden) return null;
    hidden.value = el.value;
    return el.value;
}

// ===== Buka modal untuk anggota tertentu (dari tombol "Jadikan Pengurus") =====
function openModalForMember(userId, userName) {
    // Set pilihan Choices.js ke user yang diklik
    if (anggotaChoices) {
        anggotaChoices.setChoiceByValue(String(userId));
    }
    const sel = document.getElementById('anggota_select');
    sel.value = userId;
    document.getElementById('selected_user_id').value = userId;
    // Reset state ganti
    document.getElementById('replace_existing').value = '0';

    // Tampilkan nama di header modal agar jelas
    const title = document.querySelector('#addMemberModal h3');
    if (title) {
        title.textContent = 'Tambah Pengurus' + (userName ? ' — ' + userName : '');
    }

    openModal();
}

// ===== Submit handler: cek dobel jabatan sebelum submit =====
document.getElementById('pengurusForm').addEventListener('submit', function (e) {
    const userId = syncSelectedUserId();
    if (!userId) {
        e.preventDefault();
        alert('Silakan pilih anggota terlebih dahulu.');
        return;
    }

    const oldJabatan = pengurusAktif[userId] ?? null;
    if (oldJabatan) {
        // Sudah punya jabatan aktif → tampilkan modal konfirmasi
        e.preventDefault();
        document.getElementById('confirm_move_text').textContent =
            'Mahasiswa ini sudah menjabat sebagai "' + oldJabatan + '". Ganti ke jabatan baru ini?';
        document.getElementById('replace_existing').value = '0';
        document.getElementById('confirmReplaceModal').classList.remove('hidden');
        document.getElementById('confirmReplaceModal').classList.add('flex');
    } else {
        // Tidak ada dobel jabatan → submit langsung
        document.getElementById('replace_existing').value = '0';
    }
});

// ===== Konfirmasi "Ganti" =====
function doReplace() {
    document.getElementById('replace_existing').value = '1';
    cancelReplace();
    document.getElementById('pengurusForm').submit();
}

function cancelReplace() {
    const modal = document.getElementById('confirmReplaceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection

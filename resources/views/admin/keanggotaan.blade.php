@extends('layouts.app')

@section('title', 'Persetujuan Keanggotaan')

@section('breadcrumb', 'Keanggotaan')

@section('content')
<div class="space-y-6">
    <div class="card p-6">
        <h1 class="text-2xl font-bold text-slate-900">Persetujuan Keanggotaan</h1>
        <p class="text-slate-500 mt-1 text-sm">Tinjau dan kelola permohonan pendaftaran UKM dari mahasiswa.</p>
    </div>

    @if($pending->isEmpty() && $approved->isEmpty() && $rejected->isEmpty())
        <div class="card p-12 text-center">
            <div class="text-5xl mb-3 text-slate-300">📋</div>
            <p class="text-slate-500 font-medium">Tidak ada data keanggotaan.</p>
        </div>
    @else

        @if($pending->count() > 0)
        <div class="card overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100">
                <div class="portal-stat-card-icon portal-stat-icon-gold" style="width:2.25rem;height:2.25rem;margin:0;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Permohonan Menunggu</h3>
                <span class="badge-soft bg-amber-50 text-amber-700 border-amber-200">{{ $pending->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>UKM</th>
                            <th>Tanggal</th>
                            <th class="text-center">Detail</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($pending as $index => $k)
                            <tr>
                                <td class="text-slate-400">{{ $index + 1 }}</td>
                                <td class="font-medium text-slate-800">{{ $k->user->name }}</td>
                                <td>{{ $k->user->nim }}</td>
                                <td>
                                    <span class="portal-badge portal-badge-navy">{{ $k->ukm->nama }}</span>
                                </td>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <button type="button" onclick="toggleDetail({{ $k->id }})"
                                        class="portal-btn portal-btn-secondary text-xs px-2.5 py-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </button>
                                </td>
                                <td>
                                    <div class="flex justify-center gap-1.5">
                                        <form action="{{ route('admin.keanggotaan.approve', $k) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="portal-btn portal-btn-green text-xs px-2.5 py-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Terima
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal({{ $k->id }})"
                                            class="portal-btn portal-btn-danger text-xs px-2.5 py-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="detail-{{ $k->id }}" class="hidden">
                                <td></td>
                                <td colspan="6" class="px-4 py-4 bg-slate-50/60">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">Fakultas</p>
                                            <p class="text-slate-600">{{ $k->fakultas ?: '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">Program Studi</p>
                                            <p class="text-slate-600">{{ $k->program_studi ?: '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">Angkatan</p>
                                            <p class="text-slate-600">{{ $k->angkatan ?: '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">No HP</p>
                                            <p class="text-slate-600">{{ $k->no_hp ?: '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">Email</p>
                                            <p class="text-slate-600">{{ $k->user->email }}</p>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700 mb-1">KTM</p>
                                            @if($k->ktm)
                                                <a href="{{ asset('storage/' . $k->ktm) }}" target="_blank"
                                                    class="text-blue-600 hover:underline font-semibold">Lihat KTM</a>
                                            @else
                                                <p class="text-slate-400">-</p>
                                            @endif
                                        </div>
                                        <div class="md:col-span-3">
                                            <p class="font-semibold text-slate-700 mb-1">Alasan Bergabung</p>
                                            <p class="text-slate-600">{{ $k->alasan ?: '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($approved->count() > 0)
        <div class="card overflow-hidden mt-6">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100">
                <div class="portal-stat-card-icon portal-stat-icon-green" style="width:2.25rem;height:2.25rem;margin:0;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Keanggotaan Diterima</h3>
                <span class="badge-soft bg-emerald-50 text-emerald-700 border-emerald-200">{{ $approved->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>UKM</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($approved as $index => $k)
                            <tr>
                                <td class="text-slate-400">{{ $index + 1 }}</td>
                                <td class="font-medium text-slate-800">{{ $k->user->name }}</td>
                                <td>{{ $k->user->nim }}</td>
                                <td>
                                    <span class="portal-badge portal-badge-navy">{{ $k->ukm->nama }}</span>
                                </td>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($rejected->count() > 0)
        <div class="card overflow-hidden mt-6">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100">
                <div class="portal-stat-card-icon portal-stat-icon-red" style="width:2.25rem;height:2.25rem;margin:0;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Keanggotaan Ditolak</h3>
                <span class="badge-soft bg-red-50 text-red-700 border-red-200">{{ $rejected->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>UKM</th>
                            <th>Alasan Penolakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($rejected as $index => $k)
                            <tr>
                                <td class="text-slate-400">{{ $index + 1 }}</td>
                                <td class="font-medium text-slate-800">{{ $k->user->name }}</td>
                                <td>{{ $k->user->nim }}</td>
                                <td>
                                    <span class="portal-badge portal-badge-navy">{{ $k->ukm->nama }}</span>
                                </td>
                                <td>{{ $k->alasan_penolakan ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    @endif
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white border border-[#C8D1DC] shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Permohonan</h3>
        <form id="reject-form" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan <span class="text-slate-400">(opsional)</span></label>
                <textarea name="alasan_penolakan" rows="4"
                    class="portal-textarea"
                    placeholder="Tuliskan alasan penolakan..."></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()"
                    class="portal-btn portal-btn-secondary">Batal</button>
                <button type="submit"
                    class="portal-btn portal-btn-danger">Tolak Permohonan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDetail(id) {
        const row = document.getElementById('detail-' + id);
        if (row) {
            row.classList.toggle('hidden');
        }
    }

    function openRejectModal(id) {
        const modal = document.getElementById('reject-modal');
        const form = document.getElementById('reject-form');
        form.action = "{{ url('admin/keanggotaan') }}/" + id + "/reject";
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRejectModal() {
        const modal = document.getElementById('reject-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection

@php
    $user = $member->user;
    $role = $member->jabatan->nama;
    $status = $member->status;
    $isTop = $role === 'Ketua Umum';
    $isWakil = $role === 'Wakil Ketua';
    $isKadiv = $role === 'Kepala Divisi';
    // Hanya "Kepala Divisi" yang digabung dengan nama divisi
    if ($isKadiv && $member->divisi) {
        $role = 'Kepala Divisi ' . $member->divisi->nama;
    }
@endphp
<div class="oc-node {{ $isTop ? 'oc-role-top' : ($isWakil ? 'oc-role-wakil' : ($isKadiv ? 'oc-role-kadiv' : '')) }}">
    <div class="oc-actions">
        <form action="{{ route('kepengurusan.keluar', $member) }}" method="POST" onsubmit="return confirm('Keluar dari UKM? Anggota ini akan dihapus dari struktur organisasi dan tidak bisa dipilih lagi sebagai pengurus.');">
            @csrf
            <button type="submit" title="Keluar dari UKM" class="oc-btn">✕</button>
        </form>
    </div>

    <div class="oc-avatar-wrap" onclick="openEditSlot({{ $member->id }}, {{ $member->jabatan_id }}, {{ $member->divisi_id ?? 'null' }})" title="Klik untuk ganti pengurus slot ini">
        @if($user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" class="oc-avatar-img" alt="{{ $user->name }}">
        @else
            <div class="oc-avatar-ph">
                <svg viewBox="0 0 24 24" fill="currentColor" class="oc-avatar-empty-icon">
                    <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.5c-3.3 0-9.8 1.6-9.8 4.9v2.4h19.6v-2.4c0-3.3-6.5-4.9-9.8-4.9z"/>
                </svg>
            </div>
        @endif
        <span class="oc-edit-hint">✏️</span>
    </div>

    <div class="oc-name">{{ $user->name }}</div>
    <div class="oc-role">{{ $role }}</div>
    <div class="oc-meta">NIM · {{ $user->nim }}</div>
    <div class="oc-status">
        @if($status === 'aktif')
            <span class="oc-badge oc-badge-aktif"><span class="oc-dot"></span>Aktif</span>
        @else
            <span class="oc-badge oc-badge-nonaktif"><span class="oc-dot"></span>Nonaktif</span>
        @endif
    </div>
</div>

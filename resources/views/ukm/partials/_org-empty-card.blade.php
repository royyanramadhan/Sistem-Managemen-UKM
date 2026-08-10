@php
    $role = $jabatanName ?? 'Jabatan';
    $jabId = $jabatanId ?? null;
    $divId = $divisiId ?? null;
    // Hanya "Kepala Divisi" yang digabung dengan nama divisi
    if ($role === 'Kepala Divisi' && !empty($divisiNama)) {
        $role = 'Kepala Divisi ' . $divisiNama;
    }
@endphp
<div class="oc-node oc-node-empty">
    <div class="oc-avatar-wrap oc-avatar-empty" onclick="openEmptyEditSlot({{ $jabId ?? 'null' }}, {{ $divId ?? 'null' }})" title="Klik untuk mengisi posisi ini">
        <div class="oc-avatar-ph">
            <svg viewBox="0 0 24 24" fill="currentColor" class="oc-avatar-empty-icon">
                <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.5c-3.3 0-9.8 1.6-9.8 4.9v2.4h19.6v-2.4c0-3.3-6.5-4.9-9.8-4.9z"/>
            </svg>
        </div>
        <span class="oc-edit-hint">＋</span>
    </div>
    <div class="oc-role oc-role-empty">{{ $role }}</div>
    <div class="oc-empty-text">Belum Ada Pengurus</div>
</div>

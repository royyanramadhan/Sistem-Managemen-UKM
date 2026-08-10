@php
    // Reusable status badge helper.
    // Usage: @include('partials._status-badge', ['status' => $item->status])
    // Map status -> label + color classes (black & white theme)
    $map = [
        'aktif'     => ['Aktif', 'bg-white text-black border-black'],
        'nonaktif'  => ['Nonaktif', 'bg-black text-white border-black'],
        'pending'   => ['Pending', 'bg-white text-black border-black'],
        'diterima'  => ['Diterima', 'bg-white text-black border-black'],
        'ditolak'   => ['Ditolak', 'bg-black text-white border-black'],
        // Tingkat prestasi
'lokal'         => ['Lokal', 'bg-white text-black border-black'],
        'regional'      => ['Regional', 'bg-white text-black border-black'],
        'nasional'      => ['Nasional', 'bg-white text-black border-black'],
        'internasional' => ['Internasional', 'bg-black text-white border-black'],
    ];
    $label = $map[$status][0] ?? ucfirst(str_replace('_', ' ', (string)$status));
    $classes = $map[$status][1] ?? 'bg-white text-black border-black';
@endphp
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-none text-xs font-medium border {{ $classes }}">
    @if(in_array($status, ['aktif','diterima']))
        <span class="w-1.5 h-1.5 rounded-none bg-current"></span>
    @endif
    {{ $label }}
</span>

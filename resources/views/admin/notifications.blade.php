@extends('layouts.app')

@section('title', 'Notifikasi')
@section('breadcrumb', 'Notifikasi')

@section('content')
<div class="space-y-6">
    <div class="card p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-none bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Notifikasi</h1>
                <p class="text-slate-500 text-sm mt-0.5">
                    {{ auth()->user()->unreadNotifications->count() > 0 ? auth()->user()->unreadNotifications->count() . ' notifikasi belum dibaca' : 'Semua notifikasi sudah dibaca' }}
                </p>
            </div>
        </div>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('admin.notifications.readall') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-indigo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v6a4 4 0 004 4h9l4 4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z"/></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="card p-12 text-center">
            <div class="text-5xl mb-3 text-slate-300">🔔</div>
            <p class="text-slate-500 font-medium">Belum ada notifikasi.</p>
        </div>
    @else
        <div class="card overflow-hidden">
            @foreach($notifications as $notification)
                <div class="flex items-start gap-4 p-4 border-b border-slate-50 hover:bg-slate-50/60 transition {{ $notification->read_at ? '' : 'bg-indigo-50/40' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-none {{ $notification->read_at ? 'bg-slate-100' : 'bg-indigo-100' }} flex items-center justify-center">
                        <svg class="w-5 h-5 {{ $notification->read_at ? 'text-slate-400' : 'text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">
                            {{ $notification->data['message'] ?? 'Pendaftaran UKM baru' }}
                        </p>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                            @if(!$notification->read_at)
                                <span class="badge-soft bg-amber-50 text-amber-700 border-amber-200">Baru</span>
                            @endif
                        </div>
                        @php $keanggotaanId = $notification->data['keanggotaan_id'] ?? null; @endphp
                        @if($keanggotaanId)
                            <a href="{{ route('admin.keanggotaan') }}" class="text-xs text-indigo-600 font-semibold hover:underline mt-1 inline-block">
                                Lihat Pendaftaran →
                            </a>
                        @endif
                    </div>
                    @if(!$notification->read_at)
                        <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-slate-500 hover:text-indigo-600 font-semibold">
                                Tandai dibaca
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection

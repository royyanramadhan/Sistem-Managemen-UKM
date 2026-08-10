<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Portal UKM Unimal</title>
    <meta name="description" content="Panel administrasi Portal UKM Universitas Malikussaleh">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>

    <style>
        .sidebar { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .sidebar-closed { transform: translateX(-100%); }
        .sidebar-open { transform: translateX(0); }
        @media (min-width: 1024px) {
            .main-content { transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            .main-shift { margin-left: 16rem; }
        }
        #sidebar-overlay { transition: opacity 0.25s ease; }
    </style>
</head>
<body class="antialiased min-h-screen bg-[#EEF1F5]">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar sidebar-open portal-sidebar portal-load-sidebar fixed top-0 left-0 z-50 h-full w-64 flex flex-col overflow-hidden">

        {{-- Logo --}}
        <div class="px-5 py-4 border-b border-white/10">
            <div class="flex items-center justify-between lg:block">
                <a href="{{ route('landing') }}" class="inline-flex items-center shrink-0">
                    <img src="{{ asset('images/logo-portal-ukm.png') }}"
     alt="Portal UKM"
     style="height: 90px; width: auto; max-height: none; max-width: none; object-fit: contain;">
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        @auth
        {{-- User info --}}
        <div class="px-4 py-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 object-cover border border-white/20 shrink-0">
                @else
                    <div class="w-10 h-10 bg-[#143D5C] flex items-center justify-center text-white font-bold text-sm border border-white/10 shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        @endauth

        <nav class="flex-1 py-2 overflow-y-auto">
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="px-4 pt-4 pb-1">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Menu Utama</p>
                    </div>

                    <a href="{{ route('admin.dashboard') }}" class="portal-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('landing') }}" target="_blank" class="portal-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Lihat Website
                    </a>

                    <div class="px-4 pt-5 pb-1">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kelola Data</p>
                    </div>

                    <a href="{{ route('ukm.index') }}" class="portal-nav-link {{ request()->routeIs('ukm.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Organisasi UKM
                    </a>

                    <a href="{{ route('user.index') }}" class="portal-nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Data Anggota
                    </a>

                    <a href="{{ route('berita.index') }}" class="portal-nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Berita
                    </a>

                    <div class="px-4 pt-5 pb-1">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Persetujuan</p>
                    </div>

                    <a href="{{ route('admin.keanggotaan') }}" class="portal-nav-link {{ request()->routeIs('admin.keanggotaan') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Keanggotaan
                        @if(\App\Models\Keanggotaan::where('status','pending')->count() > 0)
                            <span class="ml-auto bg-[#B8952E] text-white text-[10px] font-bold px-2 py-0.5">{{ \App\Models\Keanggotaan::where('status','pending')->count() }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.notifications') }}" class="portal-nav-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Notifikasi
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="ml-auto bg-[#B8952E] text-white text-[10px] font-bold px-2 py-0.5">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                @endif
            @endauth
        </nav>

        <div class="px-4 py-3 border-t border-white/10">
            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="portal-nav-link w-full text-left hover:!text-red-300">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
            @endauth
        </div>
    </aside>

    <div id="main-content" class="main-content main-shift min-h-screen flex flex-col">

        <header class="portal-load-topbar sticky top-0 z-30 bg-white border-b border-[#E2E8F0] px-4 lg:px-6 py-0">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="p-2 text-slate-500 hover:text-[#0B2D4A] hover:bg-slate-50 transition-colors" title="Toggle Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </button>
                    <nav class="flex items-center text-sm text-slate-500">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0B2D4A] font-medium transition-colors">Dashboard</a>
                        @hasSection('breadcrumb')
                            <span class="mx-2 text-slate-300">›</span>
                            <span class="text-[#0F172A] font-semibold">@yield('breadcrumb')</span>
                        @endif
                    </nav>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline text-xs font-semibold text-slate-400 uppercase tracking-widest px-2.5 py-1 bg-[#F1F5F9] border border-[#E2E8F0]">Admin</span>
                    <a href="{{ route('landing') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-[#0B2D4A] border border-[#C8D1DC] px-3 py-1.5 hover:bg-slate-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Website
                    </a>
                </div>
            </div>
        </header>

        <div class="px-4 lg:px-6 pt-4">
            @if ($errors->any())
                <div class="portal-alert portal-alert-error mb-4">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <ul class="space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="portal-alert portal-alert-success mb-4" id="success-alert">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <script>setTimeout(() => { const el = document.getElementById('success-alert'); if(el) el.style.display = 'none'; }, 4000);</script>
            @endif

            @if (session('error'))
                <div class="portal-alert portal-alert-error mb-4" id="error-alert">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <script>setTimeout(() => { const el = document.getElementById('error-alert'); if(el) el.style.display = 'none'; }, 4000);</script>
            @endif
        </div>

        <main class="portal-load-content flex-1 px-4 lg:px-6 py-5 portal-page">
            @yield('content')
        </main>

        <footer class="px-4 lg:px-6 py-3 border-t border-[#E2E8F0] mt-auto bg-white">
            <p class="text-center text-xs text-slate-400">&copy; {{ date('Y') }} Portal UKM — Universitas Malikussaleh</p>
        </footer>
    </div>

    <script>
        let sidebarOpen = true;
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');
        const isDesktop = () => window.innerWidth >= 1024;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-open');
                if (isDesktop()) mainContent.classList.add('main-shift');
                else overlay.classList.remove('hidden');
            } else {
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-closed');
                if (isDesktop()) mainContent.classList.remove('main-shift');
                else overlay.classList.add('hidden');
            }
        }

        if (!isDesktop()) {
            sidebarOpen = false;
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('sidebar-closed');
            mainContent.classList.remove('main-shift');
        }

        window.addEventListener('resize', () => {
            if (isDesktop()) {
                overlay.classList.add('hidden');
                if (sidebarOpen) mainContent.classList.add('main-shift');
            } else {
                mainContent.classList.remove('main-shift');
                if (!sidebarOpen) overlay.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

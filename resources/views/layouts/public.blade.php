<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal UKM') - Universitas Malikussaleh</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>
<body class="antialiased min-h-screen flex flex-col bg-[#EEF1F5]">

    <nav id="navbar" class="portal-navbar portal-load-topbar fixed w-full z-50 top-0">
        <div class="portal-container">
            <div class="flex justify-between items-center h-16">
                @include('partials._logo', ['class' => 'h-12'])

                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('landing') }}" class="portal-navbar-link {{ request()->routeIs('landing') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('landing') }}#ukm" class="portal-navbar-link">UKM</a>
                    <a href="{{ route('landing') }}#tentang" class="portal-navbar-link">Tentang</a>
                    <a href="{{ route('landing') }}#prestasi" class="portal-navbar-link">Prestasi</a>
                    <a href="{{ route('landing') }}#berita" class="portal-navbar-link">Berita</a>
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('daftar.index') }}" class="portal-navbar-link {{ request()->routeIs('daftar.*') ? 'active' : '' }}">Daftar UKM</a>
                            <a href="{{ route('profil') }}" class="portal-navbar-link {{ request()->routeIs('profil*') ? 'active' : '' }}">Profil</a>
                        @endif
                    @endauth
                </div>

                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="portal-btn portal-btn-primary text-sm">Dashboard Admin</a>
                        @else
                            <span class="text-sm font-semibold text-[#475569] hidden xl:inline">{{ auth()->user()->name }}</span>
                            <a href="{{ route('daftar.index') }}" class="portal-btn portal-btn-green text-sm">Daftar UKM</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="portal-btn portal-btn-secondary text-sm">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="portal-btn portal-btn-secondary text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="portal-btn portal-btn-primary text-sm">Daftar</a>
                    @endauth
                </div>

                <button id="mobile-menu-btn" class="lg:hidden p-2 text-[#0B2D4A]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-[#E2E8F0]">
            <div class="portal-container py-4 space-y-1">
                <a href="{{ route('landing') }}" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">Beranda</a>
                <a href="{{ route('landing') }}#ukm" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">UKM</a>
                <a href="{{ route('landing') }}#prestasi" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">Prestasi</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">Dashboard Admin</a>
                    @else
                        <a href="{{ route('daftar.index') }}" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">Daftar UKM</a>
                        <a href="{{ route('profil') }}" class="block px-3 py-2.5 text-sm font-semibold text-[#475569] hover:text-[#0B2D4A] hover:bg-slate-50">Profil</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="pt-2">
                        @csrf
                        <button type="submit" class="portal-btn portal-btn-secondary w-full text-sm">Keluar</button>
                    </form>
                @else
                    <div class="pt-3 flex gap-2">
                        <a href="{{ route('login') }}" class="portal-btn portal-btn-secondary flex-1 text-sm text-center">Masuk</a>
                        <a href="{{ route('register') }}" class="portal-btn portal-btn-primary flex-1 text-sm text-center">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    @if ($errors->any() || session('success') || session('error'))
    <div class="pt-16 portal-container w-full">
        @if ($errors->any())
            <div class="portal-alert portal-alert-error mt-4">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="portal-alert portal-alert-success mt-4" id="success-alert">{{ session('success') }}</div>
            <script>setTimeout(() => { const el = document.getElementById('success-alert'); if(el) el.style.display = 'none'; }, 4000);</script>
        @endif
        @if (session('error'))
            <div class="portal-alert portal-alert-error mt-4" id="error-alert">{{ session('error') }}</div>
            <script>setTimeout(() => { const el = document.getElementById('error-alert'); if(el) el.style.display = 'none'; }, 4000);</script>
        @endif
    </div>
    @endif

    <main class="portal-load-content flex-1 pt-16">
        @yield('content')
    </main>

    <footer class="bg-[#0B2D4A] text-slate-300 mt-auto">
        <div class="portal-container py-12">
            <div class="grid md:grid-cols-4 gap-10 pb-10 border-b border-white/10">
                <div class="md:col-span-2">
                  @include('partials._logo', ['class' => 'h-30 mb-4', 'linkClass' => 'brightness-0 invert'])
                    <p class="text-sm leading-relaxed max-w-md text-slate-400">
                        Portal Unit Kegiatan Mahasiswa Universitas Malikussaleh. Platform terpadu untuk manajemen dan informasi organisasi kemahasiswaan.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('landing') }}#ukm" class="hover:text-white transition-colors">UKM</a></li>
                        <li><a href="{{ route('landing') }}#prestasi" class="hover:text-white transition-colors">Prestasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Akses</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-white transition-colors">Login Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm">
                <p>&copy; {{ date('Y') }} Portal UKM — Universitas Malikussaleh</p>
                <p class="text-xs">Kampus Utama Cot Tengku Nie, Reuleut, Aceh Utara</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileBtn) {
                mobileBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
            }
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    const id = href.split('#')[1];
                    if (!id || !href.startsWith('#')) return;
                    e.preventDefault();
                    mobileMenu?.classList.add('hidden');
                    const target = document.getElementById(id);
                    if (target) window.scrollTo({ top: target.offsetTop - 70, behavior: 'smooth' });
                });
            });

            // Navbar shadow saat scroll
            const navbar = document.getElementById('navbar');
            if (navbar) {
                const onScroll = () => {
                    if (window.scrollY > 10) {
                        navbar.classList.add('shadow-sm');
                    } else {
                        navbar.classList.remove('shadow-sm');
                    }
                };
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();
            }
        });
    </script>
</body>
</html>

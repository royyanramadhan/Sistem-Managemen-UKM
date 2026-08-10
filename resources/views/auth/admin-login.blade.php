<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Portal UKM Universitas Malikussaleh</title>
    <meta name="description" content="Panel administrasi Portal UKM Universitas Malikussaleh">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex" style="font-family: 'IBM Plex Sans', sans-serif;">

    {{-- Left panel --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 portal-animated-bg portal-auth-left flex-col justify-between p-12 relative overflow-hidden">
        {{-- Subtle background pattern --}}
        <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(255,255,255,0.3) 40px, rgba(255,255,255,0.3) 41px), repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(255,255,255,0.3) 40px, rgba(255,255,255,0.3) 41px);"></div>
        <div class="relative z-10">
            <img src="{{ asset('images/logo-portal-ukm.png') }}" alt="Portal UKM" style="height: 90px; width: auto; max-height: none; max-width: none; object-fit: contain;">
        </div>
        <div class="relative z-10">
            <div class="inline-block px-3 py-1 bg-red-700 text-white text-xs font-bold uppercase tracking-widest mb-6">Admin Area</div>
            <h1 class="text-3xl font-bold text-white leading-tight mb-4">
                Panel Administrasi<br>Portal UKM
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed mb-8 max-w-xs">
                Kelola data UKM, anggota, keanggotaan, berita, prestasi, dan kegiatan melalui dashboard administrasi.
            </p>
            <div class="grid grid-cols-2 gap-3">
                <div class="border border-white/10 p-4">
                    <p class="text-2xl font-bold text-white">{{ \App\Models\Ukm::count() }}</p>
                    <p class="text-slate-400 text-xs uppercase tracking-wider mt-1 font-semibold">Unit UKM</p>
                </div>
                <div class="border border-white/10 p-4">
                    <p class="text-2xl font-bold text-white">{{ \App\Models\User::where('role','user')->count() }}</p>
                    <p class="text-slate-400 text-xs uppercase tracking-wider mt-1 font-semibold">Mahasiswa</p>
                </div>
            </div>
        </div>
        <p class="text-slate-500 text-xs relative z-10">&copy; {{ date('Y') }} Universitas Malikussaleh</p>
    </div>

    {{-- Right panel --}}
    <div class="flex-1 flex items-center justify-center bg-[#EEF1F5] px-6 py-12 portal-auth-right">
        <div class="w-full max-w-sm">
            <div class="lg:hidden mb-8 text-center">
                <img src="{{ asset('images/logo-portal-ukm.png') }}" alt="Portal UKM" style="height: 90px; width: auto; max-height: none; max-width: none; object-fit: contain;">
            </div>

            <div class="portal-auth-card bg-white border border-[#C8D1DC] p-8">
                <span class="inline-block px-3 py-1 bg-red-50 text-red-700 text-xs font-bold uppercase tracking-widest border border-red-200 mb-4">Admin</span>
                <h2 class="text-xl font-bold text-[#0B2D4A] mb-1">Login Administrator</h2>
                <p class="text-sm text-[#64748B] mb-6">Masuk dengan kredensial admin</p>

                @if ($errors->any())
                    <div class="portal-alert portal-alert-error mb-5">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="portal-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="portal-input" placeholder="admin@unimal.ac.id">
                    </div>
                    <div>
                        <label class="portal-label">Password</label>
                        <div class="portal-input-wrapper">
                            <input type="password" name="password" id="admin-password" required class="portal-input" placeholder="Masukkan password">
                            <button type="button" class="portal-pw-toggle" onclick="togglePassword('admin-password', this)" title="Tampilkan password">
                                <svg id="eye-icon-admin-password" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="portal-btn portal-btn-primary w-full py-3 text-sm uppercase tracking-wide">Masuk Admin</button>
                </form>
            </div>

            <p class="text-center mt-6">
                <a href="{{ route('landing') }}" class="text-sm text-[#64748B] hover:text-[#0B2D4A]">&larr; Kembali ke Beranda</a>
            </p>
        </div>
    </div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    const icon = btn.querySelector('svg');
    icon.innerHTML = isHidden
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
</script>
</body>
</html>

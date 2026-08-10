<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
// Halaman login user (pengunjung/mahasiswa)
    public function showLogin()
    {
        if (auth()->check()) {
            return auth()->user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('landing');
        }
        return view('auth.login');
    }

    // Halaman login admin (terpisah)
    public function showAdminLogin()
    {
        if (auth()->check()) {
            return auth()->user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('landing');
        }
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Kunci unik per kombinasi email + IP, supaya orang lain di IP yang
        // sama tidak ikut ke-lock kalau ada satu email yang di-brute-force.
        $throttleKey = Str::lower($credentials['email']) . '|' . $request->ip();

        // Maksimal 5 percobaan gagal per menit.
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->isAdmin()) {
                Auth::logout();
                RateLimiter::hit($throttleKey, 60);
                return back()->withErrors(['email' => 'Akun ini bukan admin.'])->withInput();
            }

            // Login berhasil: reset counter percobaan gagal.
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
        }

        // Login gagal: tambah counter percobaan (kedaluwarsa otomatis 60 detik).
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput($request->only('email'));
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'nim' => 'required|string',
            'password' => 'required',
        ]);

        $throttleKey = Str::lower($credentials['nim']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'nim' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('nim'));
        }

        // Login menggunakan NIM
        $user = User::where('nim', $request->nim)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->isAdmin()) {
                RateLimiter::hit($throttleKey, 60);
                return back()->withErrors(['nim' => 'Akun ini adalah admin. Gunakan login admin.'])->withInput($request->only('nim'));
            }
            RateLimiter::clear($throttleKey);
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('landing')->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        RateLimiter::hit($throttleKey, 60);
        return back()->withErrors(['nim' => 'NIM atau password salah.'])->withInput($request->only('nim'));
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register akun baru (user)
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'fakultas' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:4',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'nim' => $data['nim'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
            'fakultas' => $data['fakultas'] ?? null,
            'program_studi' => $data['program_studi'] ?? null,
            'angkatan' => $data['angkatan'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('landing')->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing')->with('success', 'Anda berhasil logout.');
    }

    // Dashboard admin redirect ke daftar UKM
    public function adminDashboard()
    {
        return redirect()->route('ukm.index');
    }
}

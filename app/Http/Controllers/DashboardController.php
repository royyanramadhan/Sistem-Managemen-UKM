<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Ukm;
use App\Models\User;
use App\Models\Keanggotaan;
use App\Models\Kegiatan;
use App\Models\Kepengurusan;
use App\Models\Prestasi;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman Landing Page Utama
    public function landing()
    {
        try {
            $stats = [
                'ukm' => Ukm::where('status', 'aktif')->count(),
                'mahasiswa' => User::where('role', 'user')->count(),
                'pendaftaran' => Keanggotaan::count(),
                'kegiatan' => Kegiatan::count(),
            ];

            $ukms = Ukm::where('status', 'aktif')->take(6)->get();

            // Berita terpilih untuk ditampilkan di landing page
            $beritaLanding = Berita::with('ukm')
                ->where('status', 'published')
                ->where('tampil_di_dashboard', true)
                ->orderByDesc('tanggal_publikasi')
                ->take(6)
                ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika tabel belum di-migrate, tangkap error agar web tidak crash (Healthcheck pass)
            $stats = ['ukm' => 0, 'mahasiswa' => 0, 'pendaftaran' => 0, 'kegiatan' => 0];
            $ukms = collect();
            $beritaLanding = collect();
        }

        return view('welcome', compact('stats', 'ukms', 'beritaLanding'));
    }

    // Halaman Dashboard Admin
    public function adminDashboard()
    {
        Carbon::setLocale('id');

        $stats = [
            'ukm' => Ukm::where('status', 'aktif')->count(),
            'mahasiswa' => User::where('role', 'user')->count(),
            'anggota_aktif' => Kepengurusan::where('status', 'aktif')->count(),
            'pending' => Keanggotaan::where('status', 'pending')->count(),
            'prestasi' => Prestasi::count(),
        ];

        // 5 pendaftaran terbaru (semua status)
        $recentRegistrations = Keanggotaan::with(['user', 'ukm'])
            ->latest()
            ->take(5)
            ->get();

        // 5 prestasi terbaru
        $recentPrestasi = Prestasi::with(['ukm'])
            ->latest()
            ->take(5)
            ->get();

        // Grafik aktivitas 30 hari terakhir (pendaftaran + kegiatan + prestasi)
        $startDate = now()->subDays(29)->startOfDay();
        $chartDays = collect();
        for ($i = 29; $i >= 0; $i--) {
            $chartDays->put(now()->subDays($i)->format('Y-m-d'), 0);
        }

        $countByDay = function (string $table) use ($startDate) {
            return \Illuminate\Support\Facades\DB::table($table)
                ->where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date');
        };

        $registrationsByDay = $countByDay('keanggotaans');
        $kegiatanByDay = $countByDay('kegiatans');
        $prestasiByDay = $countByDay('prestasis');

        $chartData = $chartDays->map(function ($val, $date) use ($registrationsByDay, $kegiatanByDay, $prestasiByDay) {
            return ($registrationsByDay[$date] ?? 0)
                + ($kegiatanByDay[$date] ?? 0)
                + ($prestasiByDay[$date] ?? 0);
        });

        $chartLabels = $chartDays->keys()->map(fn ($d) => Carbon::parse($d)->format('d M'))->values();
        $chartValues = $chartData->values();
        $chartHighlight = $chartValues->isEmpty() ? 0 : $chartValues->keys()->sortByDesc(fn ($k) => $chartValues[$k])->first();

        // Aktivitas terbaru (gabungan pendaftaran, kegiatan, prestasi)
        $activities = collect();

        foreach (Keanggotaan::with(['user', 'ukm'])->latest()->take(8)->get() as $item) {
            $activities->push([
                'type' => 'pendaftaran',
                'title' => 'Pendaftaran anggota',
                'subtitle' => ($item->user->name ?? 'User') . ' · ' . ($item->ukm->nama ?? 'UKM'),
                'date' => $item->created_at,
                'value' => ucfirst($item->status),
                'icon_color' => 'bg-indigo-500',
            ]);
        }

        foreach (Kegiatan::with('ukm')->latest()->take(8)->get() as $item) {
            $activities->push([
                'type' => 'kegiatan',
                'title' => $item->nama,
                'subtitle' => ($item->ukm->nama ?? 'UKM') . ' · Kegiatan baru',
                'date' => $item->created_at,
                'value' => $item->jenis ?? 'Kegiatan',
                'icon_color' => 'bg-emerald-500',
            ]);
        }

        foreach (Prestasi::with('ukm')->latest()->take(8)->get() as $item) {
            $activities->push([
                'type' => 'prestasi',
                'title' => $item->nama_prestasi,
                'subtitle' => ($item->ukm->nama ?? 'UKM') . ' · Prestasi baru',
                'date' => $item->created_at,
                'value' => $item->tingkat ?? '-',
                'icon_color' => 'bg-amber-500',
            ]);
        }

        $recentActivities = $activities
            ->sortByDesc('date')
            ->take(6)
            ->values()
            ->groupBy(function ($item) {
                $date = $item['date'];
                if ($date->isToday()) {
                    return 'Hari Ini';
                }
                if ($date->isYesterday()) {
                    return 'Kemarin';
                }

                return $date->translatedFormat('l, d F Y');
            });

        // Distribusi UKM per bidang
        $bidangRaw = Ukm::where('status', 'aktif')
            ->selectRaw('bidang, COUNT(*) as total')
            ->groupBy('bidang')
            ->orderByDesc('total')
            ->get();

        $bidangTotal = $bidangRaw->sum('total');
        $bidangDistribution = $bidangRaw->map(fn ($item) => [
            'bidang' => $item->bidang ?: 'Lainnya',
            'total' => $item->total,
            'percentage' => $bidangTotal > 0 ? round(($item->total / $bidangTotal) * 100) : 0,
        ]);

        $lastUpdated = Carbon::now()->translatedFormat('d F Y, H:i');

        return view('admin.dashboard', compact(
            'stats',
            'recentRegistrations',
            'recentPrestasi',
            'chartLabels',
            'chartValues',
            'chartHighlight',
            'recentActivities',
            'bidangDistribution',
            'lastUpdated',
        ));
    }

// Halaman informasi publik UKM (tanpa login) - untuk pengunjung website
    public function publicShow(Ukm $ukm)
    {
// Hanya tampilkan jika status UKM aktif
        abort_unless($ukm->status === 'aktif', 404);

        $ukm->load(['kepengurusans.user', 'kepengurusans.jabatan', 'kepengurusans.divisi', 'prestasis', 'kegiatans']);

        // Berita UKM ini yang sudah published
        $ukmBeritas = $ukm->beritas()->where('status', 'published')->orderByDesc('tanggal_publikasi')->get();

// Divisi milik UKM ini (bukan global) untuk struktur organisasi publik
        $divisis = $ukm->divisis()->where('status', 'aktif')->orderBy('id')->get();

        // State pendaftaran user (untuk menampilkan tombol daftar yang sesuai)
        $state = null;
        if (auth()->check() && !auth()->user()->isAdmin()) {
            $registrations = auth()->user()->keanggotaans()->with('ukm')->get();
            $state = [
                'hasPending' => $registrations->contains('status', 'pending'),
                'hasAccepted' => $registrations->contains('status', 'diterima'),
                'pendingRegistration' => $registrations->firstWhere('status', 'pending'),
                'acceptedRegistration' => $registrations->firstWhere('status', 'diterima'),
                'rejectedUkmIds' => $registrations->where('status', 'ditolak')->pluck('ukm_id')->all(),
                'acceptedUkmIds' => $registrations->where('status', 'diterima')->pluck('ukm_id')->all(),
            ];
        }

        return view('public.ukm.show', compact('ukm', 'state', 'divisis', 'ukmBeritas'));
    }

    // Menampilkan notifikasi (untuk admin)
    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        return view('admin.notifications', compact('notifications'));
    }

    // Menandai satu notifikasi sebagai sudah dibaca
    public function markNotificationRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    }

    // Menandai semua notifikasi sebagai sudah dibaca
    public function markAllNotificationsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}

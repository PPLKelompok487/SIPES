<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Role Petugas Kebersihan - Dashboard Modern
        if ($user->role === 'petugas') {
            $stats = [
                'total' => Report::count(),
                'menunggu' => Report::whereIn('status', ['pending', 'menunggu'])->count(),
                'diproses' => Report::where('status', 'diproses')->count(),
                'selesai' => Report::where('status', 'selesai')->count(),
            ];

            $recentReports = Report::with('user')->latest()->limit(5)->get();
            $priorityReports = Report::whereIn('status', ['pending', 'menunggu'])
                ->latest()
                ->limit(3)
                ->get();
            
            // Laporan dengan koordinat untuk peta
            $mapReports = Report::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->latest()
                ->limit(10)
                ->get();

            return view('petugas.dashboard', compact('stats', 'recentReports', 'priorityReports', 'mapReports'));
        }

        // Admin melihat statistik SEMUA laporan, pelapor hanya miliknya sendiri
        if ($user->role === 'admin') {
            $totalLaporan = Report::count();
            $laporanDiproses = Report::where('status', 'diproses')->count();
            $laporanSelesai = Report::where('status', 'selesai')->count();
        } else {
            $totalLaporan = Report::where('user_id', $user->id)->count();
            $laporanDiproses = Report::where('user_id', $user->id)
                ->where('status', 'diproses')
                ->count();
            $laporanSelesai = Report::where('user_id', $user->id)
                ->where('status', 'selesai')
                ->count();
        }
        
        return view('dashboard', compact('totalLaporan', 'laporanDiproses', 'laporanSelesai'));
    }
}

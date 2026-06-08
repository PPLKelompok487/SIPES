<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
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

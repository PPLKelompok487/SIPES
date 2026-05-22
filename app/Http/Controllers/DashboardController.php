<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for current user's reports
        $totalLaporan = Report::where('user_id', $user->id)->count();
        $laporanDiproses = Report::where('user_id', $user->id)
            ->where('status', 'processing')
            ->count();
        $laporanSelesai = Report::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        return view('dashboard', compact('totalLaporan', 'laporanDiproses', 'laporanSelesai'));
    }
}

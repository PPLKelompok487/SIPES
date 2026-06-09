<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'pelapor') {
            abort(403, 'Halaman ini hanya dapat diakses oleh masyarakat (pelapor).');
        }

        $query = Auth::user()->reports()->with('user');

        // Filter berdasarkan kata kunci (deskripsi atau lokasi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->whereIn('status', ['pending', 'menunggu']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $laporans = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', compact('laporans'));
    }

    public function show(Report $report)
    {
        // Pastikan hanya pelapor yang bisa melihat detail laporannya sendiri
        if (Auth::user()->role !== 'pelapor' || $report->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('laporan.show', compact('report'));
    }
}

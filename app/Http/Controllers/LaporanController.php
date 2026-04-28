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

        $laporans = Auth::user()
            ->reports()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', compact('laporans'));
    }
}

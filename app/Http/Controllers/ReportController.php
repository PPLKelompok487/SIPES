<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Auth::user()->reports()->latest()->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        if (Auth::guest() || Auth::user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat membuat laporan.');
        }

        return view('reports.create');
    }

    public function store(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat membuat laporan.');
        }

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'max:5120'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $photoPath = $request->file('photo')->store('reports', 'public');

        Auth::user()->reports()->create([
            'description' => $validated['description'],
            'location' => $validated['location'],
            'photo_path' => $photoPath,
            'status' => 'pending',
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Laporan sampah berhasil dikirim. Terima kasih atas laporannya!');
    }

    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function reverseLocation(Request $request)
    {
        $validated = $request->validate([
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
        ]);

        $response = Http::withHeaders([
            'User-Agent' => 'SIPES Location Service',
        ])->get('https://nominatim.openstreetmap.org/reverse', [
            'format' => 'json',
            'lat' => $validated['lat'],
            'lon' => $validated['lon'],
            'addressdetails' => 1,
        ]);

        if (!$response->successful()) {
            return response()->json(['message' => 'Tidak dapat mengambil lokasi saat ini.'], 500);
        }

        $data = $response->json();

        return response()->json([
            'display_name' => $data['display_name'] ?? null,
            'lat' => $data['lat'] ?? $validated['lat'],
            'lon' => $data['lon'] ?? $validated['lon'],
        ]);
    }

    // =============================================
    // Admin Methods (SIP-13)
    // =============================================

    /**
     * Tampilkan semua laporan untuk admin.
     */
    public function adminIndex(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya dapat diakses oleh admin.');
        }

        $query = Report::with('user')->latest();

        // Filter berdasarkan kata kunci (deskripsi, lokasi, atau nama pelapor)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->whereIn('status', ['pending', 'menunggu']);
            } else {
                $query->where('status', $request->status);
            }
        }

        $reports = $query->paginate(10)->withQueryString();

        return view('admin.laporan.index', compact('reports'));
    }

    /**
     * Ubah status laporan (hanya admin).
     */
    public function updateStatus(Request $request, Report $report)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh admin.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pending,menunggu,diverifikasi,diproses,selesai,ditolak'],
        ]);

        $report->update(['status' => $validated['status']]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Status laporan berhasil diubah menjadi "' . ucfirst($validated['status']) . '".');
    }
}

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
        if (Auth::guest() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas')) {
            abort(403, 'Halaman ini hanya dapat diakses oleh admin atau petugas.');
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
        $user = Auth::user();
        if (Auth::guest() || ($user->role !== 'admin' && $user->role !== 'petugas')) {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh admin atau petugas.');
        }

        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $newStatus = $validated['status'];
        $oldStatus = $report->status;

        // Workflow Status: Menunggu -> Diverifikasi -> Diproses -> Selesai
        // Atau: Menunggu -> Ditolak

        // 1. Validasi Role Admin
        if ($user->role === 'admin') {
            // Admin hanya bisa memproses laporan yang berstatus Menunggu
            if (!in_array($oldStatus, ['pending', 'menunggu'])) {
                return back()->with('error', 'Admin hanya dapat memproses laporan yang berstatus Menunggu.');
            }

            // Admin hanya bisa mengubah ke Diverifikasi atau Ditolak
            if (!in_array($newStatus, ['diverifikasi', 'ditolak'])) {
                return back()->with('error', 'Admin hanya diizinkan mengubah status menjadi Diverifikasi atau Ditolak.');
            }
        } 
        
        // 2. Validasi Role Petugas
        elseif ($user->role === 'petugas') {
            if ($oldStatus === 'diverifikasi') {
                // Petugas mengubah Diverifikasi -> Diproses
                if ($newStatus !== 'diproses') {
                    return back()->with('error', 'Petugas hanya dapat mengubah status Diverifikasi menjadi Diproses.');
                }
            } elseif ($oldStatus === 'diproses') {
                // Petugas mengubah Diproses -> Selesai
                if ($newStatus !== 'selesai') {
                    return back()->with('error', 'Petugas hanya dapat mengubah status Diproses menjadi Selesai.');
                }
            } else {
                return back()->with('error', 'Petugas tidak memiliki wewenang untuk mengubah status pada tahap ini.');
            }
        }

        $report->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Tampilkan detail laporan untuk admin.
     */
    public function adminShow(Report $report)
    {
        if (Auth::guest() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas')) {
            abort(403, 'Halaman ini hanya dapat diakses oleh admin atau petugas.');
        }

        $report->load('user');

        return view('admin.laporan.show', compact('report'));
    }

    /**
     * Hapus laporan (hanya admin).
     */
    public function adminDestroy(Report $report)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh admin.');
        }

        // Hapus foto dari storage jika ada
        if ($report->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($report->photo_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($report->photo_path);
        }

        $report->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan #' . $report->id . ' berhasil dihapus.');
    }
}

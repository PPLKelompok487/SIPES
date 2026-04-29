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
        return view('reports.create');
    }

    public function store(Request $request)
    {
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
}

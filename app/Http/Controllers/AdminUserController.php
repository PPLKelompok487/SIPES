<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Tampilkan daftar pengguna untuk admin.
     */
    public function index(Request $request)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya dapat diakses oleh admin.');
        }

        $query = User::query()->latest();

        // Filter berdasarkan kata kunci (nama atau email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Ubah role pengguna (hanya admin).
     */
    public function updateRole(Request $request, User $user)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh admin.');
        }

        // Proteksi: admin tidak bisa mengubah role dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:pelapor,petugas,admin'],
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Role pengguna "' . $user->name . '" berhasil diubah menjadi "' . ucfirst($validated['role']) . '".');
    }

    /**
     * Hapus pengguna (hanya admin).
     */
    public function destroy(User $user)
    {
        if (Auth::guest() || Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh admin.');
        }

        // Proteksi: admin tidak bisa menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna "' . $userName . '" beserta seluruh laporannya berhasil dihapus.');
    }
}

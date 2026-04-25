<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user yang sedang login.
     */
    public function show()
    {
        if (Auth::guest()) return redirect('/login');
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Tampilkan form edit profil.
     */
    public function edit()
    {
        if (Auth::guest()) return redirect('/login');
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Simpan perubahan data profil (nama & email).
     */
    public function update(Request $request)
    {
        if (Auth::guest()) return redirect('/login');
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->filled('photo_base64')) {
            $base64_string = $request->photo_base64;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_string, $type)) {
                $base64_string = substr($base64_string, strpos($base64_string, ',') + 1);
                $type = strtolower($type[1]);

                if (in_array($type, ['jpg', 'jpeg', 'png'])) {
                    $base64_data = base64_decode($base64_string);
                    if ($base64_data !== false) {
                        $fileName = uniqid() . '.' . $type;
                        $path = 'profile_photos/' . $fileName;

                        if ($user->profile_photo_path) {
                            Storage::disk('public')->delete($user->profile_photo_path);
                        }

                        Storage::disk('public')->put($path, $base64_data);
                        $user->profile_photo_path = $path;
                    }
                }
            }
        } elseif ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Tampilkan form ganti password.
     */
    public function editPassword()
    {
        if (Auth::guest()) return redirect('/login');
        return view('profile.edit-password');
    }

    /**
     * Simpan password baru.
     */
    public function updatePassword(Request $request)
    {
        if (Auth::guest()) return redirect('/login');
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah!');
    }
}

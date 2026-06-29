<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil admin.
     */
    public function index()
    {
        $admin = Auth::user();

        if (!$admin) {
            return redirect()->route('login');
        }

        return view('admin.pengaturan', compact('admin'));
    }

    /**
     * Perbarui data profil admin (nama, email, telepon, alamat/departemen, foto).
     */
    public function updateProfile(Request $request)
    {
        /** @var User|null $admin */
        $admin = Auth::user();

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $admin->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',     // sesuai struktur database
            'department' => 'nullable|string|max:100',     // opsional (jika ada di tabel)
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Cek apakah kolom address ada (di database ada)
        if (Schema::hasColumn('users', 'address')) {
            $data['address'] = $validated['address'] ?? null;
        }

        // Cek apakah kolom department ada (jika tidak ada, skip)
        if (Schema::hasColumn('users', 'department') && $request->has('department')) {
            $data['department'] = $validated['department'];
        }

        // Proses upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($admin->photo);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $data['photo'] = $path;
        }

        $admin->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data'    => $admin->fresh()
        ]);
    }

    /**
     * Perbarui preferensi sistem (tema & bahasa).
     */
    public function updatePreferences(Request $request)
    {
        /** @var User|null $admin */
        $admin = Auth::user();

        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'theme'    => 'required|in:light,dark',
            'language' => 'required|in:id,en',
        ]);

        // Cek apakah kolom theme dan language ada di tabel (di database Anda ada)
        $data = [];
        if (Schema::hasColumn('users', 'theme')) {
            $data['theme'] = $validated['theme'];
        }
        if (Schema::hasColumn('users', 'language')) {
            $data['language'] = $validated['language'];
        }

        $admin->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil diperbarui.',
            'data'    => $admin->fresh()
        ]);
    }

    /**
     * Perbarui password admin.
     */
    public function updatePassword(Request $request)
    {
        
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        /** @var User|null $admin */
        $admin = Auth::user();

        if (!Hash::check($validated['current_password'], $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah.',
            ], 422);
        }

        $admin->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }
}
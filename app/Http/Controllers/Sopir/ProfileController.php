<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Vehicle;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Validasi (Semua tentang kendaraan dibuat nullable agar tidak memaksa)
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'            => ['required', 'string', 'max:20'],
            'address'          => ['nullable', 'string'],
            'operational_area' => ['nullable', 'string', 'max:255'], // Area operasional ditambahkan
            'photo'            => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], 
            
            'old_password'     => ['nullable', 'string'],
            'password'         => ['nullable', 'string', 'min:6', 'confirmed'],
            
            // Kendaraan boleh kosong
            'plate_number'     => ['nullable', 'string', 'max:255'],
            'door_number'      => ['nullable', 'string', 'max:255'],
            'vehicle_type'     => ['nullable', 'string', 'max:255'],
            'tax_expired'      => ['nullable', 'date'],
            'stnk_expired'     => ['nullable', 'date'],

            'theme'            => ['nullable', 'in:light,dark'],
            'language'         => ['nullable', 'in:id,en'],
        ]);

        // 2. Update Password
        if ($request->filled('old_password') || $request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }
            $user->password = Hash::make($request->password);
        }

        // 3. Upload Foto
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profile-photos', 'public');
        }

        // 4. Update Identitas User
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->phone            = $request->phone;
        $user->address          = $request->address;
        $user->operational_area = $request->operational_area;
        
        if ($request->has('theme')) $user->theme = $request->theme;
        if ($request->has('language')) $user->language = $request->language;
        
        $user->save();

        // 5. Update / Buat Kendaraan Baru
        // Jika sopir mengisi No. Polisi & Pintu, baru kita simpan kendaraannya
        if ($request->filled('plate_number') && $request->filled('door_number')) {
            
            if ($request->filled('vehicle_id')) {
                // Jika sebelumnya sudah punya kendaraan -> UPDATE
                $vehicle = Vehicle::where('id', $request->vehicle_id)->where('user_id', $user->id)->first();
                if ($vehicle) {
                    $vehicle->update([
                        'plate_number' => $request->plate_number,
                        'door_number'  => $request->door_number,
                        'vehicle_type' => $request->vehicle_type,
                        'tax_expired'  => $request->tax_expired,
                        'stnk_expired' => $request->stnk_expired,
                    ]);
                }
            } else {
                // Jika belum punya kendaraan sama sekali -> CREATE BARU
                Vehicle::create([
                    'user_id'      => $user->id,
                    'plate_number' => $request->plate_number,
                    'door_number'  => $request->door_number,
                    'vehicle_type' => $request->vehicle_type,
                    'tax_expired'  => $request->tax_expired,
                    'stnk_expired' => $request->stnk_expired,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
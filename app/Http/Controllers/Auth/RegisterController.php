<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi.
     */
    public function register(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            // User fields
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'phone'                 => 'required|string|max:20|unique:users,phone',
            'password'              => 'required|string|min:8|confirmed',
            'address'               => 'nullable|string|max:500',
            'operational_area'      => 'nullable|string|max:255',

            // Vehicle fields
            'plate_number'          => 'required|string|max:255|unique:vehicles,plate_number',
            'door_number'           => 'required|string|max:255',
            'vehicle_type'          => 'required|string|max:255',
            'fuel_type'             => 'nullable|string|max:50',
            'wheels_count'          => 'nullable|integer|min:2',
            'tax_expired'           => 'nullable|date',
            'stnk_expired'          => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name'              => $request->name,
            'username'          => $request->username,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'password'          => Hash::make($request->password),
            'role'              => 'sopir',            // default sopir
            'status'            => 'aktif',
            'address'           => $request->address,
            'operational_area'  => $request->operational_area,
            'join_date'         => now()->toDateString(),
        ]);

        // Buat kendaraan untuk user tersebut
        Vehicle::create([
            'user_id'       => $user->id,
            'plate_number'  => $request->plate_number,
            'door_number'   => $request->door_number,
            'vehicle_type'  => $request->vehicle_type,
            'fuel_type'     => $request->fuel_type,
            'wheels_count'  => $request->wheels_count,
            'tax_expired'   => $request->tax_expired,
            'stnk_expired'  => $request->stnk_expired,
        ]);

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')
            ->with('status', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
}
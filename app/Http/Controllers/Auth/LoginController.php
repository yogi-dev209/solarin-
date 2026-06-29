<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login admin
     */
    public function showAdminLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('admin.login');
    }

    /**
     * Tampilkan form login sopir
     */
    public function showSopirLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('sopir.login');
    }

    /**
     * Proses login (sama untuk admin dan sopir)
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek status aktif
        if ($user->status === 'nonaktif') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi admin.',
            ]);
        }

        // 🔐 Validasi role sesuai dengan login_type
        $loginType = $request->input('login_type', 'sopir');

        if ($loginType === 'admin' && !in_array($user->role, ['admin', 'manajemen_driver', 'senior_manager'])) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini bukan admin atau manajemen.',
            ]);
        }

        if ($loginType === 'sopir' && $user->role !== 'sopir') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini bukan sopir.',
            ]);
        }

        // Update last login
        $user->last_login = now();
        $user->save();

        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : 'sopir';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login sesuai role
        if (in_array($role, ['admin', 'manajemen_driver', 'senior_manager'])) {
            return redirect()->route('admin.login');
        }

        return redirect()->route('sopir.login');
    }

    /**
     * Redirect berdasarkan role setelah login
     */
    private function redirectByRole()
    {
        $role = Auth::user()->role;

        if (in_array($role, ['admin', 'manajemen_driver', 'senior_manager'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('sopir.dashboard');
    }
}
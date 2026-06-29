<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSopirRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SopirController extends Controller
{
    // ==============================================
    // CRUD SOPIR (digunakan di halaman data-sopir)
    // ==============================================

    public function index(Request $request)
    {
        $query = User::where('role', 'sopir');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%")
                    ->orWhere('operational_area', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sopirs = $query->with('vehicles')->latest()->paginate(15);

        return view('admin.sopir.data-sopir', compact('sopirs'));
    }

    public function create()
    {
        return view('admin.sopir.create'); 
    }

    public function store(StoreSopirRequest $request)
    {
        User::create([
            'name'             => $request->name,
            'username'         => $request->username,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'password'         => Hash::make($request->password),
            'role'             => 'sopir',
            'status'           => 'aktif',
            'operational_area' => $request->operational_area,
            'address'          => $request->address,
            'join_date'        => $request->join_date ?? now(),
        ]);

        return redirect()->route('admin.sopir.index')
            ->with('success', 'Data sopir berhasil ditambahkan.');
    }

    public function edit(User $sopir)
    {
        abort_if($sopir->role !== 'sopir', 404);
        return view('admin.sopir.edit', compact('sopir'));
    }

    public function update(StoreSopirRequest $request, User $sopir)
    {
        abort_if($sopir->role !== 'sopir', 404);

        $data = [
            'name'             => $request->name,
            'username'         => $request->username,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'operational_area' => $request->operational_area,
            'address'          => $request->address,
            'join_date'        => $request->join_date,
            'status'           => $request->filled('status') ? $request->status : $sopir->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $sopir->update($data);

        return back()->with('success', 'Data sopir berhasil diperbarui.');
    }

    public function toggleStatus(User $sopir)
    {
        abort_if($sopir->role !== 'sopir', 404);

        $sopir->update([
            'status' => $sopir->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return back()->with('success', 'Status sopir berhasil diubah.');
    }

    public function destroy(User $sopir)
    {
        abort_if($sopir->role !== 'sopir', 404);
        $sopir->delete();
        return back()->with('success', 'Data sopir berhasil dihapus.');
    }

    // ==============================================
    // MANAJEMEN USER (hanya daftar, toggle status, hapus)
    // ==============================================

    public function manageIndex(Request $request)
    {
        $query = User::where('role', 'sopir');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.activity-logs.manajemen-user', compact('users'));
    }

    // ==============================================
    // UPDATE LOKASI (GPS) untuk sopir
    // ==============================================

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();

        if (!$user || $user->role !== 'sopir') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        User::where('id', $user->id)->update([
            'last_latitude' => $request->latitude,
            'last_longitude' => $request->longitude,
            'last_location_updated' => now(),
        ]);

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }
}
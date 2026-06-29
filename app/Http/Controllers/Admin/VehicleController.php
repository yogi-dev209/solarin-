<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVehicleRequest;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Menyimpan data kendaraan baru dari Modal Tambah Kendaraan
     */
    public function store(StoreVehicleRequest $request)
    {
        // Langsung simpan data truk + user_id ke database
        Vehicle::create($request->validated());

        // Redirect kembali ke halaman asal modal (misal: halaman data-sopir atau profil)
        return back()->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kendaraan dari Modal Edit Kendaraan
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return back()->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Menghapus data kendaraan
     */
    public function destroy(Vehicle $vehicle)
    {
        // Cegah hapus kendaraan yang sudah punya riwayat pengajuan agar tidak error cascading
        if ($vehicle->submissions()->exists()) {
            return back()->withErrors([
                'error' => 'Kendaraan ini punya riwayat pengajuan dan tidak bisa dihapus. Silakan nonaktifkan saja jika perlu.'
            ]);
        }

        $vehicle->delete();

        return back()->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
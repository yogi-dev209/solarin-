<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        $vehicleId = $this->route('vehicle')?->id;

        return [
            // Cukup butuh user_id untuk nyambungin ke data nama/email/password sopir
            'user_id'      => ['required', Rule::exists('users', 'id')->where('role', 'sopir')],
            'plate_number' => ['required', 'string', 'max:255', Rule::unique('vehicles', 'plate_number')->ignore($vehicleId)],
            'door_number'  => ['required', 'string', 'max:255'],
            'vehicle_type' => ['required', 'string', 'max:255'],
            'fuel_type'    => ['nullable', 'string', 'max:255'],
            'wheels_count' => ['nullable', 'integer', 'min:1'],
            'tax_expired'  => ['nullable', 'date'],
            'stnk_expired' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'      => 'ID Sopir pemilik wajib diisi (Sistem Error).',
            'user_id.exists'        => 'Sopir tidak ditemukan atau bukan akun sopir.',
            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique'   => 'Nomor plat ini sudah terdaftar di kendaraan lain.',
            'door_number.required'  => 'Nomor lambung wajib diisi.',
            'vehicle_type.required' => 'Jenis kendaraan wajib diisi.',
        ];
    }
}
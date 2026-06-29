<?php

namespace App\Http\Requests\Sopir;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'vehicle_id'     => ['required', 'exists:vehicles,id'],
            'foto_kendaraan' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'stnk_pajak'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.required'     => 'Kendaraan wajib dipilih.',
            'foto_kendaraan.required' => 'Foto kendaraan wajib diunggah.',
            'stnk_pajak.required'     => 'Foto STNK & Pajak wajib diunggah.',
            'foto_kendaraan.max'      => 'Ukuran foto kendaraan maksimal 5MB.',
            'stnk_pajak.max'          => 'Ukuran foto STNK & Pajak maksimal 5MB.',
        ];
    }
}
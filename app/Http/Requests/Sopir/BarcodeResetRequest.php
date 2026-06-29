<?php

namespace App\Http\Requests\Sopir;

use Illuminate\Foundation\Http\FormRequest;

class BarcodeResetRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'reason'    => ['required', 'string', 'min:10', 'max:500'],
            'confirmed' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required'    => 'Alasan reset wajib diisi.',
            'reason.min'         => 'Alasan minimal 10 karakter.',
            'confirmed.accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
        ];
    }
}
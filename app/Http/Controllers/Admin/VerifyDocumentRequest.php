<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyDocumentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'status'     => ['required', Rule::in(['disetujui', 'revisi', 'ditolak'])],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status verifikasi wajib dipilih.',
            'status.in'        => 'Status verifikasi tidak valid.',
        ];
    }
}
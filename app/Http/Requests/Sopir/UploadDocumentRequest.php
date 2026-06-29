<?php

namespace App\Http\Requests\Sopir;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File wajib diunggah.',
            'file.image'    => 'File harus berupa gambar.',
            'file.max'      => 'Ukuran file maksimal 5MB.',
        ];
    }
}
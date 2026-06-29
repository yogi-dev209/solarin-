<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadBarcodeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $submission = $this->route('submission');
        $hasExistingBarcode = (bool) $submission?->barcode;

        return [
            'barcode_file' => [$hasExistingBarcode ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'note'         => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'barcode_file.required' => 'File barcode wajib diunggah.',
            'barcode_file.image'    => 'File barcode harus berupa gambar.',
            'barcode_file.max'      => 'Ukuran file barcode maksimal 5MB.',
        ];
    }
}
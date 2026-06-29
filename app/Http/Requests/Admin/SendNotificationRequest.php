<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendNotificationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'sopir')],
            'message' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Sopir penerima wajib dipilih.',
            'user_id.exists'   => 'Sopir tidak ditemukan.',
            'message.required' => 'Pesan notifikasi tidak boleh kosong.',
        ];
    }
}
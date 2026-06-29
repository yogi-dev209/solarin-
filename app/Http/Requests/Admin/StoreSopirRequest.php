<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSopirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Kalau ini request update, route binding-nya {sopir} -> ambil id buat ignore unique check
        $sopirId = $this->route('sopir')?->id;

        return [
            'name'             => ['required', 'string', 'max:255'],
            'username'         => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($sopirId)],
            'email'            => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($sopirId)],
            'phone'            => ['required', 'string', 'max:20'],
            'password'         => [$sopirId ? 'nullable' : 'required', 'string', 'min:6'],
            'operational_area' => ['nullable', 'string', 'max:255'],
            'address'          => ['nullable', 'string'],
            'join_date'        => ['nullable', 'date'],
            'status'           => ['nullable', 'in:aktif,nonaktif'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'phone.required'    => 'Nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ];
    }
}
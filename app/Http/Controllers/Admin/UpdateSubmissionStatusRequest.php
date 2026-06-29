<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubmissionStatusRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                'menunggu_verifikasi', 'diproses', // 'perlu_revisi' dihapus
                'disetujui', 'ditolak',
                'pengajuan_sanggah', 'menunggu_upload_barcode', 'menunggu_penerbitan',
            ])],
            'rejection_reason' => ['required_if:status,ditolak', 'nullable', 'string', 'max:500'],
            'note'             => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'              => 'Status wajib dipilih.',
            'status.in'                    => 'Status tidak valid.',
            'rejection_reason.required_if' => 'Alasan penolakan wajib diisi kalau status ditolak.',
        ];
    }
}
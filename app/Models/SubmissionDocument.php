<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'document_type',
        'file',
        'status',
        'admin_note',
    ];

    // Pengajuan tempat dokumen ini diupload
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'submission_id');
    }
}
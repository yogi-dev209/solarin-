<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('action', [
                'pengajuan_dibuat',
                'dokumen_diupload',
                'dokumen_diverifikasi',
                'dokumen_direvisi',
                'dokumen_ditolak',
                'status_berubah',
                'barcode_diterbitkan',
                'reset_diajukan',
                'reset_disetujui',
                'reset_ditolak',
                'pengajuan_sanggah',
            ]);
            $table->string('description')->nullable(); // contoh: "Status berubah dari menunggu ke diverifikasi"
            $table->string('old_value')->nullable();   // nilai sebelumnya
            $table->string('new_value')->nullable();   // nilai sesudahnya
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
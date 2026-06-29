<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadBarcodeRequest;
use App\Models\Barcode;
use App\Models\Submission;
use App\Services\ActivityLogService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarcodeController extends Controller
{
    public function __construct(
        private ActivityLogService  $activityLog,
        private NotificationService $notification
    ) {}

    // 1. Tampilkan Halaman Daftar Pengajuan yang Siap Diupload Barcodenya
    public function index()
    {
        // Ambil data yang sudah 'diproses' (dokumen disetujui) atau yang sudah 'barcode_terbit'
        $submissions = Submission::with(['vehicle.user', 'barcode'])
            ->whereIn('status', ['diproses', 'disetujui', 'menunggu_upload_barcode', 'menunggu_penerbitan', 'barcode_terbit'])
            ->latest()
            ->get();

        return view('admin.barcodes.upload-barcode', compact('submissions'));
    }

    // 2. Proses Upload / Update file barcode (dipanggil lewat AJAX fetch dari blade)
    public function upload(UploadBarcodeRequest $request, Submission $submission)
    {
        $existingBarcode = $submission->barcode;

        $data = [
            'barcode_number' => $existingBarcode->barcode_number ?? ('BC-' . $submission->submission_code),
            'issued_date'    => $existingBarcode->issued_date ?? now()->toDateString(),
            'note'           => $request->note,
        ];

        if ($request->hasFile('barcode_file')) {
            // Hapus file lama jika ada (agar storage tidak penuh)
            if ($existingBarcode?->barcode_file) {
                Storage::disk('public')->delete($existingBarcode->barcode_file);
            }
            // Simpan gambar baru
            $data['barcode_file'] = $request->file('barcode_file')->store('barcodes', 'public');
        }

        $barcode = Barcode::updateOrCreate(['submission_id' => $submission->id], $data);

        // Ubah status pengajuan menjadi barcode_terbit
        $submission->update([
            'status'       => 'barcode_terbit',
            'processed_by' => Auth::id(),
        ]);

        $this->activityLog->log($submission, Auth::user(), 'barcode_diterbitkan', [
            'description' => "Barcode {$barcode->barcode_number} diterbitkan.",
        ]);

        return response()->json([
            'success'        => true,
            'message'        => 'Barcode berhasil diunggah dan disimpan.',
            'barcode_number' => $barcode->barcode_number,
        ]);
    }

    // 3. Tombol "Kirim Notifikasi Sopir" (Dipanggil via AJAX)
    public function notify(Submission $submission)
    {
        abort_if(! $submission->barcode, 422, 'Barcode belum diupload untuk pengajuan ini.');

        $this->notification->sendToUser(
            $submission->vehicle->user,
            'Barcode Solar Subsidi Terbit',
            "Barcode untuk kendaraan {$submission->vehicle->plate_number} telah diterbitkan. Silakan buka aplikasi SolarIn Anda untuk melihatnya.",
            'barcode'
        );

        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dikirim ke sopir.']);
    }
}
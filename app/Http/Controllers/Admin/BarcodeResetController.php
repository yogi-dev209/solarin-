<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarcodeResetRequest;
use App\Services\ActivityLogService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarcodeResetController extends Controller
{
    public function __construct(
        private ActivityLogService  $activityLog,
        private NotificationService $notification
    ) {}

    public function index()
    {
        // Ambil data reset dari database
        $resets = BarcodeResetRequest::with(['barcode.submission.vehicle.user'])
            ->latest()
            ->get();

        return view('admin.barcodes.reset-barcode', compact('resets'));
    }

    public function approve(Request $request, BarcodeResetRequest $reset)
    {
        abort_if($reset->status !== 'menunggu', 422, 'Permintaan reset ini sudah diproses sebelumnya.');

        $request->validate(['admin_note' => 'nullable|string|max:500']);

        $reset->update(['status' => 'disetujui', 'admin_note' => $request->admin_note]);

        $submission = $reset->barcode->submission;
        
        // Kembalikan status pengajuan agar admin bisa upload barcode yang baru
        $submission->update(['status' => 'menunggu_upload_barcode']);

        $this->activityLog->log($submission, Auth::user(), 'reset_disetujui', [
            'description' => 'Pengajuan reset barcode disetujui, menunggu barcode baru diterbitkan.',
        ]);

        $this->notification->sendToUser(
            $submission->vehicle->user,
            'Reset Barcode Disetujui',
            "Permintaan reset barcode untuk kendaraan {$submission->vehicle->plate_number} telah disetujui. Harap tunggu barcode baru.",
            'reset'
        );

        return response()->json(['success' => true, 'message' => 'Reset barcode disetujui.']);
    }

    public function reject(Request $request, BarcodeResetRequest $reset)
    {
        abort_if($reset->status !== 'menunggu', 422, 'Permintaan reset ini sudah diproses sebelumnya.');

        $request->validate(['admin_note' => 'required|string|max:500']);

        $reset->update(['status' => 'ditolak', 'admin_note' => $request->admin_note]);

        $submission = $reset->barcode->submission;

        $this->activityLog->log($submission, Auth::user(), 'reset_ditolak', [
            'description' => "Reset barcode ditolak: {$request->admin_note}",
        ]);

        $this->notification->sendToUser(
            $submission->vehicle->user,
            'Reset Barcode Ditolak',
            "Permintaan reset barcode ditolak. Alasan: {$request->admin_note}",
            'reset'
        );

        return response()->json(['success' => true, 'message' => 'Reset barcode ditolak.']);
    }
}
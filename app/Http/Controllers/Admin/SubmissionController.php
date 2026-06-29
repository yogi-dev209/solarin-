<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSubmissionStatusRequest;
use App\Models\Submission;
use App\Services\ActivityLogService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function __construct(
        private ActivityLogService  $activityLog,
        private NotificationService $notification
    ) {}

    // ========================================================
    // 1. DAFTAR SEMUA PENGAJUAN (Dinamic)
    // ========================================================
    public function index(Request $request)
    {
        // HAPUS 'verifiedBy' dari sini agar tidak error
        $submissions = Submission::with(['vehicle.user'])->latest()->get();

        return view('admin.submissions.data-pengajuan', compact('submissions'));
    }

    // ========================================================
    // 2. UBAH STATUS PENGAJUAN (Manual)
    // ========================================================
    public function updateStatus(UpdateSubmissionStatusRequest $request, Submission $submission)
    {
        $oldStatus = $submission->status;
        $newStatus = $request->status;

        abort_if(
            $newStatus === 'barcode_terbit',
            422,
            'Status barcode_terbit hanya bisa diset lewat proses upload barcode.'
        );

        $updateData = ['status' => $newStatus];

        if (in_array($newStatus, ['diproses', 'disetujui', 'menunggu_upload_barcode', 'menunggu_penerbitan'])) {
            $updateData['verified_by'] = auth::id();
            $updateData['verified_at'] = now();
        }

        if ($newStatus === 'ditolak') {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        if ($request->filled('note')) {
            $updateData['note'] = $request->note;
        }

        $submission->update($updateData);

        $this->activityLog->log($submission, auth::user(), 'status_berubah', [
            'description' => "Status diubah dari {$oldStatus} menjadi {$newStatus}",
            'old_value'   => $oldStatus,
            'new_value'   => $newStatus,
        ]);

        $this->notification->sendToUser(
            $submission->vehicle->user,
            'Update Status Pengajuan',
            "Status pengajuan kendaraan {$submission->vehicle->plate_number} diubah menjadi {$newStatus}.",
            'pengajuan'
        );

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    // ========================================================
    // 3. MONITORING SEMUA PENGAJUAN AKTIF
    // ========================================================
    public function monitoring(Request $request)
    {
        // HAPUS 'verifiedBy' dan 'processedBy' dari sini agar tidak error
        $query = Submission::with(['vehicle.user'])
            ->whereNotIn('status', ['barcode_terbit', 'ditolak']);

        $submissions = $query->latest()->get();

        return view('admin.activity-logs.monitoring-pengajuan', compact('submissions'));
    }

    // Fungsi show dibiarkan jika sewaktu-waktu butuh rute detail spesifik
    public function show(Submission $submission)
    {
        $submission->load(['vehicle.user', 'documents', 'barcode', 'activityLogs.user']);
        return view('admin.submissions.show', compact('submission'));
    }
}
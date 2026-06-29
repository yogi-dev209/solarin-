<?php

namespace App\Http\Controllers\Sopir;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sopir = Auth::user();

        // ── Kendaraan Sopir ───────────────────────────────────────────
        $vehicle = Vehicle::where('user_id', $sopir->id)
            ->with([
                'submissions' => fn($q) => $q->latest()->limit(1),
                'submissions.barcode',
                'submissions.documents',
                'submissions.barcode.resetRequests' => fn($q) => $q->latest()->limit(1),
            ])
            ->first();

        $submission  = $vehicle?->submissions->first();
        $barcode     = $submission?->barcode;
        $dokumen     = $submission?->documents ?? collect();
        $latestReset = $barcode?->resetRequests->first();

        // ── Status Dokumen ────────────────────────────────────────────
        $dokumenMenunggu  = $dokumen->where('status', 'menunggu')->count();
        $dokumenDisetujui = $dokumen->where('status', 'disetujui')->count();
        $dokumenRevisi    = $dokumen->where('status', 'revisi')->count();

        // ── Peringatan Kendaraan ──────────────────────────────────────
        $stnkExpired  = $vehicle?->stnk_expired  && now()->gt($vehicle->stnk_expired);
        $pajakExpired = $vehicle?->tax_expired    && now()->gt($vehicle->tax_expired);
        $stnkNearExp  = $vehicle?->stnk_expired  && now()->diffInDays($vehicle->stnk_expired, false) <= 30
                        && !$stnkExpired;
        $pajakNearExp = $vehicle?->tax_expired    && now()->diffInDays($vehicle->tax_expired, false) <= 30
                        && !$pajakExpired;

        // ── Notifikasi ────────────────────────────────────────────────
        $notifications = Notification::where('user_id', $sopir->id)
            ->latest()
            ->limit(5)
            ->get();

        $unreadNotif = Notification::where('user_id', $sopir->id)
            ->where('is_read', false)
            ->count();

        // ── Riwayat Aktivitas Pengajuan ───────────────────────────────
        $activityLogs = $submission
            ? ActivityLog::where('submission_id', $submission->id)
                ->with('user')
                ->latest()
                ->limit(8)
                ->get()
            : collect();

        return view('sopir.dashboard.dashboard', compact(
            // profil
            'sopir',
            // kendaraan
            'vehicle', 'stnkExpired', 'pajakExpired', 'stnkNearExp', 'pajakNearExp',
            // pengajuan
            'submission', 'barcode', 'dokumen',
            'dokumenMenunggu', 'dokumenDisetujui', 'dokumenRevisi',
            // reset
            'latestReset',
            // notif
            'notifications', 'unreadNotif',
            // aktivitas
            'activityLogs'
        ));
    }
}
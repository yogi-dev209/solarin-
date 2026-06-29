<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Submission;
use App\Models\User;

class ActivityLogService
{
    public function log(Submission $submission, User $user, string $action, array $options = []): ActivityLog
    {
        return ActivityLog::create([
            'submission_id' => $submission->id,
            'user_id'       => $user->id,
            'action'        => $action,
            'description'   => $options['description'] ?? null,
            'old_value'     => $options['old_value'] ?? null,
            'new_value'     => $options['new_value'] ?? null,
        ]);
    }
}
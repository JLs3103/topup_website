<?php

namespace App\Support;

use App\Models\AdminActivityLog;
use App\Models\User;

class AdminActivityLogger
{
    /**
     * @param  array<string, mixed>|null  $meta
     */
    public static function log(
        User $admin,
        string $action,
        string $targetType,
        ?int $targetId,
        string $description,
        ?array $meta = null,
    ): void {
        AdminActivityLog::create([
            'admin_id' => $admin->id,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $description,
            'meta' => $meta,
        ]);
    }
}

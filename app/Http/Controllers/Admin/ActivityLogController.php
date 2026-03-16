<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = AdminActivityLog::query()
            ->with('admin:id,name,email')
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs.index', compact('logs'));
    }
}

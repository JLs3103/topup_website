<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\TopupOrder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        $stats = [
            'total_orders' => TopupOrder::query()->where('user_id', $user->id)->count(),
            'pending_orders' => TopupOrder::query()->where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => TopupOrder::query()->where('user_id', $user->id)->where('status', 'success')->count(),
            'total_spend' => TopupOrder::query()->where('user_id', $user->id)->sum('package_price'),
        ];

        $recentNotifications = $user->notifications()->latest()->limit(6)->get();
        $unreadCount = $user->unreadNotifications()->count();

        return view('account.index', compact('user', 'stats', 'recentNotifications', 'unreadCount'));
    }

    public function faq()
    {
        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('support.faq', compact('faqs'));
    }

    public function markNotificationsRead(): RedirectResponse
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('status', 'Semua notifikasi ditandai sudah dibaca.');
    }
}

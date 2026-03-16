<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopupOrder;
use App\Models\User;
use App\Notifications\OrderStatusUpdatedNotification;
use App\Support\AdminActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderVerificationController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['paid', 'pending', 'success', 'failed'])],
            'q' => ['nullable', 'string', 'max:50'],
        ]);

        $query = TopupOrder::query();

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        } else {
            $query->where('status', 'paid');
        }

        if (! empty($validated['q'])) {
            $keyword = $validated['q'];
            $query->where(function ($inner) use ($keyword): void {
                $inner->where('order_code', 'like', "%{$keyword}%")
                    ->orWhere('game_name', 'like', "%{$keyword}%")
                    ->orWhere('player_id', 'like', "%{$keyword}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'selectedStatus' => $validated['status'] ?? 'paid',
            'keyword' => $validated['q'] ?? '',
        ]);
    }

    public function show(TopupOrder $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, TopupOrder $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['success', 'failed'])],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        if ($order->status !== 'paid') {
            return back()->withErrors(['status' => 'Status transaksi ini tidak dapat diverifikasi lagi.']);
        }

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        $meta = $order->metadata ?? [];
        $meta['verification_note'] = $validated['admin_note'] ?? null;
        $meta['verified_by'] = Auth::id();
        $meta['verified_at'] = now()->toDateTimeString();

        $order->update([
            'status' => $newStatus,
            'metadata' => $meta,
        ]);

        $order->loadMissing('user');

        if ($order->user) {
            $order->user->notify(new OrderStatusUpdatedNotification(
                $order,
                $oldStatus,
                $newStatus,
                $validated['admin_note'] ?? null,
            ));
        }

        $admin = Auth::user();
        if ($admin instanceof User) {
            AdminActivityLogger::log(
                admin: $admin,
                action: 'order_status_updated',
                targetType: 'topup_order',
                targetId: $order->id,
                description: 'Admin mengubah status transaksi '.$order->order_code.' dari '.$oldStatus.' menjadi '.$newStatus.'.',
                meta: [
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'admin_note' => $validated['admin_note'] ?? null,
                ],
            );
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Status transaksi berhasil diperbarui ke '.strtoupper($newStatus).'.');
    }
}

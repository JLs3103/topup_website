<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TopupOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TopupController extends Controller
{
    public function show(string $slug)
    {
        $games = config('topup_games.games', []);
        $game = $games[$slug] ?? null;

        abort_unless($game, 404);

        return view('topup.show', [
            'game' => $game,
            'paymentMethods' => config('topup_games.payment_methods', []),
        ]);
    }

    public function store(Request $request, string $slug)
    {
        $games = config('topup_games.games', []);
        $game = $games[$slug] ?? null;

        abort_unless($game, 404);

        $packageIds = array_keys($game['packages']);
        $paymentMethodIds = array_keys(config('topup_games.payment_methods', []));

        $validated = $request->validate([
            'player_id' => ['required', 'string', 'max:50'],
            'server_id' => $game['requires_server']
                ? ['required', 'string', 'max:50']
                : ['nullable', 'string', 'max:50'],
            'package_id' => ['required', Rule::in($packageIds)],
            'payment_method' => ['required', Rule::in($paymentMethodIds)],
            'contact_type' => ['required', Rule::in(['whatsapp', 'email'])],
            'contact_value' => ['required', 'string', 'max:100'],
        ]);

        if ($validated['contact_type'] === 'email' && ! filter_var($validated['contact_value'], FILTER_VALIDATE_EMAIL)) {
            return back()
                ->withErrors(['contact_value' => 'Format email tidak valid.'])
                ->withInput();
        }

        if ($validated['contact_type'] === 'whatsapp' && ! preg_match('/^[0-9+]{8,20}$/', $validated['contact_value'])) {
            return back()
                ->withErrors(['contact_value' => 'Nomor WhatsApp tidak valid.'])
                ->withInput();
        }

        $selectedPackage = Arr::get($game, 'packages.'.$validated['package_id']);

        abort_if(! $selectedPackage, 422);

        $order = TopupOrder::create([
            'user_id' => Auth::id(),
            'order_code' => $this->generateOrderCode(),
            'game_slug' => $game['slug'],
            'game_name' => $game['name'],
            'player_id' => $validated['player_id'],
            'server_id' => $validated['server_id'] ?? null,
            'package_id' => $validated['package_id'],
            'package_name' => $selectedPackage['name'],
            'package_price' => $selectedPackage['price'],
            'payment_method' => $validated['payment_method'],
            'contact_type' => $validated['contact_type'],
            'contact_value' => $validated['contact_value'],
            'status' => 'pending',
            'metadata' => [
                'payment_label' => config('topup_games.payment_methods.'.$validated['payment_method']),
            ],
        ]);

        return redirect()
            ->route('orders.index')
            ->with('status', 'Pesanan '.$order->order_code.' berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function orderHistory(Request $request)
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(403);
        }

        $isAdmin = $user->isAdmin();

        $validated = $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'paid', 'success', 'failed', 'canceled'])],
            'q' => ['nullable', 'string', 'max:50'],
        ]);

        $query = TopupOrder::query()->with('user:id,name,email');

        if (! $isAdmin) {
            $query->where('user_id', $user->id);
        }

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (! empty($validated['q'])) {
            $keyword = $validated['q'];

            $query->where(function ($innerQuery) use ($keyword): void {
                $innerQuery->where('order_code', 'like', "%{$keyword}%")
                    ->orWhere('game_name', 'like', "%{$keyword}%")
                    ->orWhere('player_id', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($userQuery) use ($keyword): void {
                        $userQuery->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $statusCountQuery = TopupOrder::query();

        if (! $isAdmin) {
            $statusCountQuery->where('user_id', $user->id);
        }

        $statusCounts = $statusCountQuery
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('topup.orders', [
            'orders' => $orders,
            'statusCounts' => $statusCounts,
            'selectedStatus' => $validated['status'] ?? '',
            'keyword' => $validated['q'] ?? '',
            'isAdminView' => $isAdmin,
        ]);
    }

    public function showOrder(TopupOrder $order)
    {
        abort_unless($this->canAccessOrder($order), 403);

        return view('topup.order-detail', compact('order'));
    }

    public function submitPaymentProof(Request $request, TopupOrder $order)
    {
        abort_unless($this->canAccessOrder($order), 403);

        if ($order->status !== 'pending') {
            return back()->withErrors([
                'payment_proof' => 'Pesanan ini tidak lagi menerima upload bukti pembayaran.',
            ]);
        }

        $validated = $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:3072'],
            'payment_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $storedPath = $validated['payment_proof']->store('payment-proofs', 'public');

        if ($order->payment_proof_path) {
            Storage::disk('public')->delete($order->payment_proof_path);
        }

        $order->update([
            'payment_proof_path' => $storedPath,
            'payment_notes' => $validated['payment_notes'] ?? null,
            'paid_at' => now(),
            'status' => 'paid',
        ]);

        return redirect()->route('orders.show', $order)->with('status', 'Bukti pembayaran berhasil dikirim. Pesanan menunggu verifikasi admin.');
    }

    private function generateOrderCode(): string
    {
        return 'TRX-'.now()->format('YmdHis').'-'.Str::upper(Str::random(4));
    }

    private function canAccessOrder(TopupOrder $order): bool
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return false;
        }

        return $order->user_id === $user->id || $user->isAdmin();
    }
}

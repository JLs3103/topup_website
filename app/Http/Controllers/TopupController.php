<?php

namespace App\Http\Controllers;

use App\Models\TopupOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

    public function orderHistory()
    {
        $orders = TopupOrder::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('topup.orders', compact('orders'));
    }

    private function generateOrderCode(): string
    {
        return 'TRX-'.now()->format('YmdHis').'-'.Str::upper(Str::random(4));
    }
}

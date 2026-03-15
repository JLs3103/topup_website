<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-100">{{ __('Reset Password') }}</h2>
        <p class="mt-1 text-sm text-gray-400">{{ __('We will send a reset link to your email.') }}</p>
    </div>

    <div class="mb-4 text-sm text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <div>
            <x-input-label for="email" class="text-gray-300" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 focus:bg-indigo-600 active:bg-indigo-700 focus:ring-indigo-400">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>

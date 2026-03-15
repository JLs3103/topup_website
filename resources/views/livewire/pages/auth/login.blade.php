<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-100">{{ __('Welcome Back') }}</h2>
        <p class="mt-1 text-sm text-gray-400">{{ __('Please enter your details to access your account.') }}</p>
    </div>

    <form wire:submit="login">
        <div>
            <x-input-label for="email" class="text-gray-300" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" class="text-gray-300" :value="__('Password')" />

            <div class="relative">
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full pr-10 border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400"
                                x-bind:type="show ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <svg x-show="!show" class="h-5 w-5 text-gray-500 hover:text-indigo-300 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="h-5 w-5 text-gray-500 hover:text-indigo-300 transition" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.51-3.2m5.032-2.1a3 3 0 014.243 4.243m-9.9-9.9l14.142 14.142" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-600 bg-gray-900 text-indigo-500 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-300 hover:text-indigo-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-900" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 focus:bg-indigo-600 active:bg-indigo-700 focus:ring-indigo-400">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-400">
        {{ __("Don't have an account?") }}
        <a href="{{ route('register') }}" class="font-medium text-indigo-300 hover:text-indigo-200 underline" wire:navigate>
            {{ __('Sign up') }}
        </a>
    </div>
</div>

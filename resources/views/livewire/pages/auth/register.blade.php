<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-100">{{ __('Create Account') }}</h2>
        <p class="mt-1 text-sm text-gray-400">{{ __('Join now to start topup quickly and securely.') }}</p>
    </div>

    <form wire:submit="register">
        <div>
            <x-input-label for="name" class="text-gray-300" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" class="text-gray-300" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" class="text-gray-300" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" class="text-gray-300" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-gray-700 bg-gray-950/70 text-gray-100 placeholder:text-gray-500 focus:border-indigo-400 focus:ring-indigo-400"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-indigo-300 hover:text-indigo-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-900" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 focus:bg-indigo-600 active:bg-indigo-700 focus:ring-indigo-400">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>

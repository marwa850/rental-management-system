{{-- <x-layouts.auth.simple>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="login" class="flex flex-col gap-6">
            <!-- Email Address -->
            <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus
                autocomplete="email" placeholder="email@example.com" />

            <!-- Password -->
            <div class="relative">
                <flux:input wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="current-password" :placeholder="__('Password')" viewable />

                @if (Route::has('password.request'))
                    <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox wire:model="remember" :label="__('Remember me')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Don\'t have an account?') }}
                <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth.simple> --}}
<x-layouts.auth.simple>
    <style>
        .uiverse-container {
            max-width: 350px;
            background: linear-gradient(0deg, #fff 0%, #f4f7fb 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid #fff;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 30px 30px -20px;
            margin: 40px auto;
        }

        .uiverse-heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(16, 137, 211);
        }

        .uiverse-form {
            margin-top: 20px;
        }

        .uiverse-input-wrapper {
            margin-top: 15px;
        }


        .uiverse-forgot {
            display: block;
            margin-top: 8px;
            font-size: 11px;
            color: #0099ff;
            text-decoration: none;
            text-align: right;
        }

        .uiverse-login-button {
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white !important;
            padding-block: 15px;
            margin-top: 25px;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
            width: 100%;
        }

        .uiverse-login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.88) 0px 23px 10px -20px;
        }
    </style>

    <div class="uiverse-container">
        <div class="uiverse-heading">Login </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="login" class="uiverse-form">
            <!-- Email Address -->
            <!-- Email -->
            <div class="uiverse-input-wrapper">
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Email address') }}
                </label>
                <flux:input id="email" wire:model="email" type="email" required autofocus autocomplete="email"
                    placeholder="email@example.com"
                    style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />
            </div>

            <!-- Password -->
            <div class="uiverse-input-wrapper relative">
                <label for="password"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Password') }}
                </label>
                <flux:input id="password" wire:model="password" type="password" required
                    autocomplete="current-password" :placeholder="__('Password')" viewable
                    style="width: 100%; background: white; border: none; padding: 15px 20px; border-radius: 20px; box-shadow: #cff0ff 0px 10px 10px -5px; color: rgb(18, 177, 209);" />

                @if (Route::has('password.request'))
                    <flux:link :href="route('password.request')" wire:navigate class="uiverse-forgot">
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <div style="margin-top: 10px; margin-left: 5px;">
                <label
                    style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 500; color: #0099ff;">
                    <input type="checkbox" wire:model="remember"
                        style="width: 11px; height: 11px; accent-color: #88898a; cursor: pointer;" />
                    {{ __('Remember me') }}
                </label>
            </div>



            <!-- Submit -->
            <div>
                <flux:button variant="primary" type="submit" class="uiverse-login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mt-4">
                {{ __("Don't have an account?") }}
                <flux:link :href="route('register')" wire:navigate class="text-zinc-600 hover:underline">
                    {{ __('Sign up') }}
                </flux:link>
            </div>
        @endif
    </div>
</x-layouts.auth.simple>

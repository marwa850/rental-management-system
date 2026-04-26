<section class="w-full" >
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')" >
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6" style="border: 2px solid #0D5EA6; border-radius: 8px; padding: 20px;box-shadow: rgba(133, 189, 215, 0.88) 18px 18px 10px -18px;">
            <label for="name"
                style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                {{ __('Name') }}
            </label>
            <flux:input wire:model="name" type="text" required  autocomplete="name"
                style="color:#0D5EA6; border: 1px solid black;" />

            <div>
                <label for="email"
                    style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                    {{ __('Email') }}
                </label>
                <flux:input wire:model="email" type="email" required  autocomplete="email"
                    style="color:#0D5EA6; border: 1px solid black;" />


                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4" style="color:#0D5EA6;">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification" style="color:#0D5EA6;">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full"
                        style="background-color:rgba(16, 165, 211, 0.539);">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3 !text-green-600" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>

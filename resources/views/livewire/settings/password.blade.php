<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6" style="border: 2px solid #0D5EA6; border-radius: 8px; padding: 20px;box-shadow: rgba(133, 189, 215, 0.88) 18px 18px 10px -18px;">

            <label for="current password"
                style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                {{ __('Current password') }}
            </label>
            <flux:input wire:model="current_password" type="password" required autocomplete="current-password" style="color:#0D5EA6; border: 1px solid black;" />
            <label for="new password"
                style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                {{ __('New password') }}
            </label>
            <flux:input wire:model="password"  type="password" required
                autocomplete="new-password" style="color:#0D5EA6; border: 1px solid black;" />
            <label for="confirm Password"
                style="color: #0099ff; font-weight: 500; display: block; margin-bottom: 6px; font-size: 14px;">
                {{ __('Confirm Password') }}
            </label>
            <flux:input wire:model="password_confirmation"  type="password" required
                autocomplete="new-password" style="color:#0D5EA6; border: 1px solid black;"  />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" style="background-color:rgba(16, 165, 211, 0.539);">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3 !text-green-600" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>

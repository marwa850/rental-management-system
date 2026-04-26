<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')"  style="color: #414142;">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance"  style="color: #414142;">
            <flux:radio value="light" icon="sun" style="color: #0D5EA6;" >{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon"  style="color: #0D5EA6;">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>

<div class="flex items-start max-md:flex-col" >
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('settings.profile')" wire:navigate style="color: #414142; font-weight:900;">{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('settings.password')" wire:navigate style="color: #414142; font-weight: 900;">{{ __('Password') }}</flux:navlist.item>
            {{-- <flux:navlist.item :href="route('settings.appearance')" wire:navigate style="color: #414142;">{{ __('Appearance') }}</flux:navlist.item> --}}
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading style="color: #414142;">{{ $heading ?? '' }}</flux:heading>
        <flux:subheading style="color: #414142;">{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>

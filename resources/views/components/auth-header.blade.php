@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl" style="color: #414142;">{{ $title }}</flux:heading>
    <flux:subheading style="color: #414142;">{{ $description }}</flux:subheading>
</div>

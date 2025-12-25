@props(['viewType', 'iconName'])

<button type="button" wire:click="$set('currentView', '{{ $viewType }}')"
    onclick="document.getElementById('study-section').scrollIntoView({ behavior: 'smooth', block: 'start'})"
    class="flex flex-row gap-2 text-brand-secondary-600 hover:text-brand-secondary-400">
    {{ $slot }}
    <img src="{{ asset('images/icons/' . $iconName) }}" alt="right-arrow" class="w-4">
</button>
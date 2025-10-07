@props(['sectionTitle', 'modalName'])

<header class="flex flex-row justify-between">
    <h2 class="text-2xl font-medium text-gray-900">
        {{ __($sectionTitle) }}
    </h2>

    {{-- button to add a new record --}}
    <x-profile-section.partials.add-icon :modalName="$modalName">
    </x-profile-section.partials.add-icon>
</header>

<div>
    {{ $slot }}
</div>

@props(['sectionTitle', 'modalName'])

<x-section>
    <header class="flex flex-row justify-between">
        <h2 class="text-2xl font-medium text-gray-900">
            {{ __($sectionTitle) }}
        </h2>

        {{-- button to add a new record --}}
        <x-section.partials.add-icon :modalName="$modalName" />
    </header>

    <div>
        {{ $slot }}
    </div>
</x-section>

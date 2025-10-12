@props(['sectionTitle', 'modalName'])

<section {{ $attributes->merge([
    'class' => 'space-y-2 p-4 sm:p-8 bg-white shadow sm:rounded-lg
',
]) }}>

    <header class="flex flex-row justify-between">
        <h2 class="text-2xl font-medium text-gray-900">
            {{ __($sectionTitle) }}
        </h2>

        {{-- button to add a new record --}}
        <x-section.partials.add-icon 
            x-data=""
            x-on:click="$dispatch('open-modal', '{{ $modalName }}')" 
        />
    </header>

    <div>
        {{ $slot }}
    </div>

</section>

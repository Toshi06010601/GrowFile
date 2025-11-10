{{-- About section --}}
<x-side-section>
    <x-slot name="header" class="flex flex-row justify-between">
        <h2 class="text-xl font-medium text-gray-700">
            About
        </h2>
        <x-section.edit-icon x-data=""
            x-on:click="
                    $dispatch('set-bio', { id: {{ $profile->id }} });" />
    </x-slot>
    <div class="text-gray-600">
        <p>{{ Str::limit($profile->bio, 200) }}</p>
    </div>
</x-side-section>

{{-- About section --}}
<x-side-section>
    <x-slot name="header" class="flex flex-row justify-between">
        <h2 class="text-xl font-medium text-gray-700">
            About
        </h2>
        
        @can('update', $profile)
            <x-section.edit-icon 
                x-data=""
                x-on:click="
                        $dispatch('set-bio', { id: {{ $profile->id }} });" />
        @endcan
    </x-slot>
    <div
        x-data="{ open: true }" 
        class="text-gray-600">
        <p x-show="open">{{ Str::limit($profile->bio, 200, '') }} <button @click="open = false">...see more</button></p>
        <p x-show="!open">{{ $profile->bio }} <button @click="open = true">...see less</button></p>
    </div>
</x-side-section>

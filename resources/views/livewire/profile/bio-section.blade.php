{{-- About section --}}
<x-side-section>

    {{-- Header --}}
    <x-slot name="header" class="flex flex-row justify-between">
        <h2 class="text-lg sm:text-xl font-medium text-gray-700">
            About
        </h2>
        
        {{-- Edit button for owner --}}
        @can('update', $profile)
            <x-section.edit-icon 
                x-data=""
                x-on:click="
                        $dispatch('set-bio', { id: {{ $profile->id }} });" />
        @endcan
    </x-slot>

    {{-- Bio (Shorten to 200 if longer) --}}
    <div class="text-gray-600 text-base sm:text-lg">
        @if (Str::length($profile->bio) > 200)
            <div
                x-data="{ open: true }">
                <p x-show="open">{{ Str::limit($profile->bio, 200, 'aaa') }} <button @click="open = false">...see more</button></p>
                <p x-show="!open">{{ $profile->bio }} <button @click="open = true">...see less</button></p>
            </div>
        @else
            <p>{{ $profile->bio }}</p>
        @endif
    </div>
</x-side-section>

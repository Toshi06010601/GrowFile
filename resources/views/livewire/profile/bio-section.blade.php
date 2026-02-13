{{-- About section --}}
<x-side-section>

    {{-- Header --}}
    <x-slot name="header" class="flex flex-row justify-between">
        <h2 class="text-xl font-semibold text-brand-secondary-700">
            About
        </h2>

        {{-- Edit button for owner --}}
        @can('update', $this->profile)
            <x-section.edit-icon x-data=""
                x-on:click="
                        $dispatch('set-bio', { id: {{ $this->profile->id }} });" />
        @endcan
    </x-slot>
    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load bio. Please try again.</x-loading-error>
    @endif

    {{-- Bio (Shorten to 200 if longer) --}}
    @if (!$hasError)
        <div class="text-brand-secondary-600 text-base">
            @if (Str::length($this->profile->bio) > 200)
                <div x-data="{ open: true }">
                    <p x-show="open">{{ Str::limit($this->profile->bio, 200, 'aaa') }} <button
                            @click="open = false">...see more</button></p>
                    <p x-show="!open">{{ $this->profile->bio }} <button @click="open = true">...see less</button></p>
                </div>
            @else
                <p>{{ $this->profile->bio }}</p>
            @endif
        </div>
    @endif
</x-side-section>

{{-- Background image section --}}
<section>
    <div class="relative max-h-32 rounded-lg overflow-hidden mx-auto mb-0 sm:mb-4">
    {{-- Error State --}}
    @if ($hasError)
        <x-loading-error>Failed to load background image. Please try again.</x-loading-error>
    @endif

    {{-- Display background image below --}}
    @if (!$hasError)
        <img src="{{ asset("/storage/{$this->profile->background_image_path}") }}" alt="background image" class="w-full h-full object-cover">

        {{-- Edit button for owner --}}
        @can('update', $this->profile)
            <x-section.edit-icon x-data=""
                x-on:click.stop="
                        $dispatch('set-background', { id: {{ $this->profile->id }} });"
                class="absolute bottom-1 right-1" />
        @endcan
    @endif
    </div>
</section>

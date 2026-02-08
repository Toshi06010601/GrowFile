{{-- Background image section --}}
<section>
    <div class="relative max-h-32 rounded-lg overflow-hidden mx-auto mb-0 sm:mb-4">
        {{-- Display background image --}}
        <img src="{{ $profile->background_image_path }}" alt="background image" class="w-full h-full object-cover">

        {{-- Edit button for owner --}}
        @can('update', $profile)
            <x-section.edit-icon x-data=""
                x-on:click.stop="
                        $dispatch('set-background', { id: {{ $profile->id }} });"
                class="absolute bottom-1 right-1" />
        @endcan
    </div>
</section>

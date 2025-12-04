{{-- Background image section --}}
<section>
    <div class="relative max-h-32 rounded-lg overflow-hidden mx-auto mb-0 sm:mb-4">
        {{-- Display background image --}}
        <img src="{{ $profile->background_image_path }}"
            alt="background image" class="w-full h-full object-cover">

        {{-- Edit button for owner --}}
        @can('update', $profile)
            <div class="absolute bg-white w-8 h-8 rounded-full z-10 bottom-1 right-1 flex justify-center items-center">
                <x-section.edit-icon x-data=""
                    x-on:click="
                        $dispatch('set-background', { id: {{ $profile->id }} });" />
            </div>
        @endcan
    </div>
</section>

{{-- Background image section --}}
<section>
    <div class="relative max-h-32 rounded-lg overflow-hidden mx-auto mb-4">
        <img src="{{ $profile->background_image_path ? $profile->background_image_path : 'storage/background_photos/default.png' }}"
            alt="background image" class="w-full h-full object-cover">
        <x-section.edit-icon 
            class="absolute z-10 bottom-1 right-1"
            x-data=""
            x-on:click="
                    $dispatch('set-background', { id: {{ $profile->id }} });" />
    </div>
</section>

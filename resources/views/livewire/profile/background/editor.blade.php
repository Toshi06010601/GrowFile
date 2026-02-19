{{-- modal  --}}
<x-modal name="edit-background" :show="false" focusable>

    <x-modal.icon-close />

    <form wire:submit="save" class="px-6 pt-14 pb-6">

        <x-modal.header-title>
            Edit Background
        </x-modal.header-title>

        <div class="max-h-32 rounded-lg overflow-hidden mx-auto mb-4 border-2 border-brand-secondary-400">
            {{-- Check if a new file has been selected --}}
            @if ($form->background_image && Str::startsWith($form->background_image->getMimeType(), 'image/'))
                <img src="{{ $form->background_image->temporaryUrl() }}" alt="New background image preview"
                    class="w-full h-full object-cover">
            @else
                {{-- Fallback to the existing background image URL --}}
                <img src="{{ $form->background_image_path ? asset("/storage/{$form->background_image_path}") : '/storage/background_photos/default.jpg' }}" alt="Current background image" class="w-full h-full object-cover">
            @endif
        </div>

        {{-- File input field --}}
        <input type="file" class="w-full" wire:model.blur="form.background_image">

        {{-- Display validation error --}}
        <div>
            @error('form.background_image')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <x-modal.submit-buttons name="update" :deletable="false"/>
    </form>

</x-modal>

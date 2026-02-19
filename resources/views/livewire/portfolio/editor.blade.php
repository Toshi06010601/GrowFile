{{-- modal  --}}
<x-modal name="edit-portfolio" :show="false" :focusable="$isOwner">

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update portfolio --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            @if ($isOwner)
                {{ $form->portfolio ? 'Edit' : 'Add' }} portfolio    
            @else
                View portfolio
            @endif
        </x-modal.header-title>

        {{-- Title --}}
        <x-modal.input-text label="Name" id="title" name="form.title" placeholder="Name of your portfolio"
            :disabled="!$isOwner" :required="$isOwner" />

        {{-- Description --}}
        <x-modal.input-textarea label="Description" id="description" name="form.description"
            placeholder="Describe your portfolio..." :disabled="!$isOwner" />

        {{-- Site URL --}}
        <x-modal.input-text label="Site URL" id="site_url" name="form.site_url" placeholder="Site URL" :disabled="!$isOwner" />

        <x-input-label for="site_image" value="Site Image Path" class="text-lg mt-4" />

        {{-- Site image path --}}
        <div>
            <div
                class="aspect-video mt-1 w-full rounded-lg overflow-hidden mx-auto mb-4 border-2 border-brand-secondary-400">
                {{-- Check if a new file has been selected --}}
                @if ($form->site_image && Str::startsWith($form->site_image->getMimeType(), 'image/'))
                    <img src="{{ $form->site_image->temporaryUrl() }}" alt="New site image preview"
                        class="w-full h-full object-cover">
                @else
                    {{-- Fallback to the existing site image URL --}}
                    <img src="{{ $form->site_image_path !== '' ? asset("/storage/{$form->site_image_path}") : '/storage/site_photos/default.jpg' }}"
                        alt="Current site image" class="w-full h-full object-cover">
                @endif
            </div>

            @if ($isOwner)
                {{-- File input field --}}
                <input type="file" class="w-full" wire:model="form.site_image">

                {{-- Display validation error --}}
                <div>
                    @error('form.site_image')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
            @endif
        </div>

        {{-- Github URL --}}
        <x-modal.input-text label="Github URL" id="github_url" name="form.github_url" placeholder="Github URL"
            :disabled="!$isOwner" />

        {{-- Comment --}}
        <x-modal.input-textarea label="Comment" id="comment" name="form.comment" placeholder="Describe your portfolio..."
            :disabled="!$isOwner" />

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$form->portfolio ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>

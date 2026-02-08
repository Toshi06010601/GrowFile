{{-- modal  --}}
<x-modal name="edit-article" :show="false" focusable>
   
        {{-- Session flash message --}}
        <x-session-flash-message></x-session-flash-message>

        {{-- Modal close button --}}
        <x-modal.icon-close />

        {{-- form to update article --}}
        <form wire:submit="save" class="px-6 pt-14 pb-6">

            {{-- Form title --}}
            <x-modal.header-title>
                {{ $form->article ? 'Edit' : 'Add' }} Article
            </x-modal.header-title>

            {{-- Title --}}
            <x-modal.input-text label="Title" id="title" name="form.title" placeholder="Name of your article"
                :disabled="!$isOwner" :required="true" />

            {{-- Description --}}
            <x-modal.input-textarea label="Description" id="description" name="form.description"
                placeholder="Describe your article..." :disabled="!$isOwner" />

            {{-- Article URL --}}
            <x-modal.input-text label="Article URL" id="article_url" name="form.article_url" placeholder="Article URL"
                :disabled="!$isOwner" />

            <x-input-label for="article_image" value="Article Image" class="text-lg mt-4" />

            {{-- article image path --}}
            <div>
                <div
                    class="aspect-video mt-1 w-full rounded-lg overflow-hidden mx-auto mb-4 border-2 border-brand-secondary-400">
                    {{-- Check if a new file has been selected --}}
                    @if ($form->article_image && Str::startsWith($form->article_image->getMimeType(), 'image/'))
                        <img src="{{ $form->article_image->temporaryUrl() }}" alt="New article image preview"
                            class="w-full h-full object-cover">
                    @else
                        {{-- Fallback to the existing article image URL --}}
                        <img src="{{ $form->article_image_path !== '' ? asset("storage/{$form->article_image_path}") : '/storage/article_photos/default.jpg' }}"
                            alt="Current article image" class="w-full h-full object-cover">
                    @endif
                </div>

                @if ($isOwner)
                    {{-- File input field --}}
                    <input type="file" class="w-full" wire:model="form.article_image">

                    {{-- Display validation error --}}
                    <div>
                        @error('form.article_image')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>
                @endif
            </div>

            {{-- Platform Name --}}
            <x-modal.input-text label="Platform Name" id="platform_name" name="form.platform_name"
                placeholder="Platform Name" :disabled="!$isOwner" :required="true" />

            {{-- Published Date --}}
            <x-modal.input-date label="Published Date" id="published_date" name="form.published_date"
                placeholder="Describe your article..." :disabled="!$isOwner" :required="true" />

            @if ($isOwner)
                {{-- Save/Update button --}}
                <x-modal.submit-buttons :name="$form->article ? 'update' : 'save'" />
            @endif
        </form>

</x-modal>

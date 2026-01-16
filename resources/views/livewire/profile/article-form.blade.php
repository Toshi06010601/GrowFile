{{-- modal  --}}
<x-modal name="edit-article" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update article --}}
    <form wire:submit="{{ $article ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $article ? 'Edit' : 'Add' }} Article
        </x-modal.header-title>

        {{-- Title --}}
        <x-modal.input-text label="Name" id="title" name="title" placeholder="Name of your article"
            :disabled="!$isOwner" />

        {{-- Description --}}
        <x-modal.input-textarea label="Description" id="description" name="description"
            placeholder="Describe your article..." :disabled="!$isOwner" />

        {{-- Article URL --}}
        <x-modal.input-text label="Article URL" id="article_url" name="article_url" placeholder="Article URL" :disabled="!$isOwner" />

        <x-input-label for="article_image" value="article Image Path" class="text-lg mt-4" />

        {{-- article image path --}}
        <div>
            <div
                class="aspect-video mt-1 w-full rounded-lg overflow-hidden mx-auto mb-4 border-2 border-brand-secondary-400">
                {{-- Check if a new file has been selected --}}
                @if ($article_image && Str::startsWith($article_image->getMimeType(), 'image/'))
                    <img src="{{ $article_image->temporaryUrl() }}" alt="New article image preview"
                        class="w-full h-full object-cover">
                @else
                    {{-- Fallback to the existing article image URL --}}
                    <img src="{{ $article_image_path !== '' ? $article_image_path : '/storage/article_photos/default.jpg' }}"
                        alt="Current article image" class="w-full h-full object-cover">
                @endif
            </div>

            @if ($isOwner)
                {{-- File input field --}}
                <input type="file" class="w-full" wire:model="article_image">

                {{-- Display validation error --}}
                <div>
                    @error('article_image')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>
            @endif
        </div>

        {{-- Platform Name --}}
        <x-modal.input-text label="Platform Name" id="platform_name" name="platform_name" placeholder="Platform Name"
            :disabled="!$isOwner" />

        {{-- Published Date --}}
        <x-modal.input-date label="Published Date" id="published_date" name="published_date" placeholder="Describe your article..."
            :disabled="!$isOwner" />

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$article ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>

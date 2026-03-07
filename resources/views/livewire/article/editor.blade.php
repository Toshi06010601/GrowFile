{{-- modal  --}}
<x-modal name="edit-article" :show="false" :focusable="$isOwner">

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update article --}}
    <form wire:submit="save" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            @if ($isOwner)
                {{ $form->article ? __('professional-profile.edit-article') : __('professional-profile.add-article') }}
            @else
                {{ __('professional-profile.view-article') }}
            @endif
        </x-modal.header-title>

        {{-- Title --}}
        <x-modal.input-text label="{{ __('professional-profile.title') }}" id="title" name="form.title"
            placeholder="{{ __('professional-profile.article-name-placeholder') }}" :disabled="!$isOwner"
            :required="$isOwner" />

        {{-- Platform Name --}}
        <x-modal.input-text label="{{ __('professional-profile.platform-name') }}" id="platform_name"
            name="form.platform_name" placeholder="{{ __('professional-profile.platform-name-placeholder') }}"
            :disabled="!$isOwner" :required="$isOwner" />

        {{-- Description --}}
        <x-modal.input-textarea label="{{ __('professional-profile.description') }}" id="description"
            name="form.description" placeholder="{{ __('professional-profile.article-description-placeholder') }}"
            :disabled="!$isOwner" />

        {{-- Article URL --}}
        <x-modal.input-text label="{{ __('professional-profile.article-url') }}" id="article_url"
            name="form.article_url" placeholder="{{ __('professional-profile.article-url-placeholder') }}"
            :disabled="!$isOwner" />

        <x-input-label for="article_image" value="{{ __('professional-profile.article-image') }}"
            class="text-lg mt-4" />

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

        {{-- Published Date --}}
        <x-modal.input-date label="{{ __('professional-profile.published-at') }}" id="published_date"
            name="form.published_date" placeholder="{{ __('professional-profile.article-date-placeholder') }}"
            :disabled="!$isOwner" :required="$isOwner" />

        @if ($isOwner)
            {{-- Save/Update button --}}
            <x-modal.submit-buttons :name="$form->article ? 'update' : 'save'" />
        @endif
    </form>

</x-modal>

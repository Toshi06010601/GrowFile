{{-- modal  --}}
<x-modal name="edit-reading-log" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update study record --}}
    <form wire:submit="{{ $readingLog ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $readingLog ? 'Edit' : 'Add' }} reading log
        </x-modal.header-title>

        {{-- title --}}
        <x-modal.input-text label="title" id="book-title" name="title"
            placeholder="title" />

        {{-- Book cover --}}
        <x-modal.input-text label="Book cover" id="book-cover" name="cover_url"
            placeholder="Book cover url" />

        {{-- Tags --}}
         {{-- <livewire:Profile.Partials.TagSelector wire:model="selectedTags"/> --}}

        {{-- Author --}}
        <x-modal.input-text label="Author" id="author" name="author" placeholder="Author Name" />
 
        {{-- Current Page --}}
        <x-modal.input-text label="Current Page" id="current_page" name="current_page" placeholder="Current page" />
 
        {{-- Total pages --}}
        <x-modal.input-text label="Total pages" id="total_pages" name="total_pages" placeholder="Total pages" />


        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$readingLog ? 'update' : 'save'" />
    </form>

</x-modal>

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

        {{-- Book search area --}}
        <div x-data="{ open: false }" @click.away="open = false" class="relative mb-4">
            {{-- search input field --}}
            <input 
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-secondary-500 focus:ring-brand-secondary-500" 
                wire:model.live.debounce.300ms="search"
                @focus="open = true"
                @keydown.escape.prevent="open = false" 
                autocomplete="off" 
                placeholder="Search books..."
            >

            {{-- Show books that match the search input --}}
            @if ($suggestions && count($suggestions) > 0)
                <div 
                    x-show="open" 
                    x-transition
                    class="absolute top-full left-0 z-20 w-full mt-1 max-h-64 overflow-y-auto bg-white border-2 border-brand-secondary-300 rounded-md shadow-lg"
                >
                    <ul class="divide-y divide-gray-200">
                        @foreach ($suggestions as $suggest)
                            <li 
                                wire:key="{{ $suggest['id'] }}" 
                                @click="open = false"
                                class="flex flex-row gap-3 p-3 hover:bg-brand-secondary-50 cursor-pointer transition"
                            >
                                @if(data_get($suggest, 'volumeInfo.imageLinks.thumbnail'))
                                    <img 
                                        src="{{ data_get($suggest, 'volumeInfo.imageLinks.thumbnail') }}"
                                        alt="book cover" 
                                        class="w-16 h-20 object-cover flex-shrink-0"
                                    >
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">
                                        {{ data_get($suggest, 'volumeInfo.title') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ collect(data_get($suggest, 'volumeInfo.authors'))->join(', ') ?: '著者不明' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- title --}}
        <x-modal.input-text label="title" id="book-title" name="title" placeholder="title" />

        {{-- Book cover --}}
        <x-modal.input-text label="Book cover" id="book-cover" name="cover_url" placeholder="Book cover url" />

        {{-- Author --}}
        <x-modal.input-text label="Author" id="author" name="author" placeholder="Author Name" />

        {{-- Current Page --}}
        <x-modal.input-text label="Current Page" id="current_page" name="current_page" placeholder="Current page" />

        {{-- Total pages --}}
        <x-modal.input-text label="Total pages" id="total_pages" name="total_pages" placeholder="Total pages" />

        {{-- Review --}}
        <x-modal.input-textarea label="Review" id="review" name="review"
            placeholder="Write your thoughts or feedback here" />

        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$readingLog ? 'update' : 'save'" />
    </form>

</x-modal>
{{-- modal  --}}
<x-modal name="edit-reading-log" :show="false" focusable>

    {{-- Modal close button --}}
    <x-modal.icon-close />

    {{-- form to update reading log --}}
    <form wire:submit="{{ $readingLog ? 'update' : 'save' }}" class="px-6 pt-14 pb-6">

        {{-- Form title --}}
        <x-modal.header-title>
            {{ $readingLog ? 'Edit' : 'Add' }} reading log
        </x-modal.header-title>

        @if ($isOwner)
            {{-- Book search area --}}
            <div x-data="{ open: false }" @click.away="open = false" class="relative mb-4">
                {{-- Label --}}
                <x-input-label for="book-search" value="Find your book" class="text-lg mt-4" />

                {{-- search input field --}}
                <input id="book-search"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-secondary-500 focus:ring-brand-secondary-500"
                    wire:model.live.debounce.800ms="search" @focus="open = true" @keydown.escape.prevent="open = false"
                    autocomplete="off" placeholder="Search books...">

                {{-- loading indicator --}}
                <p wire:loading wire:target="search" class="mt-2 text-sm text-gray-500 italic flex items-center gap-2">
                    <img src="{{ asset('/images/icons/spinner.svg')}}" alt="spinner" class="animate-spin h-4 w-4">
                    Searching books...
                </p>

                {{-- Validation error --}}
                <div>
                    @error('title')
                        <x-input-error :messages="$message" class="mt-2" />
                    @enderror
                </div>

                {{-- Show books that match the search input --}}
                @if ($suggestions && count($suggestions) > 0)
                    <div x-show="open" x-transition
                        class="absolute top-full left-0 z-20 w-full mt-1 max-h-64 overflow-y-auto bg-white border-2 border-brand-secondary-300 rounded-md shadow-lg">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($suggestions as $suggest)
                                <li wire:key="{{ $suggest['id'] }}" @click="open = false"
                                    wire:click="selectBook('{{ $suggest['id'] }}')"
                                    class="flex flex-row gap-3 p-3 hover:bg-brand-secondary-50 cursor-pointer transition">
                                    @if (data_get($suggest, 'volumeInfo.imageLinks.thumbnail'))
                                        <img src="{{ data_get($suggest, 'volumeInfo.imageLinks.thumbnail') }}"
                                            alt="book cover" class="w-16 h-20 object-cover flex-shrink-0">
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
        @endif

        @if ($title)
            <div
                class="flex items-center gap-4 p-4 mb-4 bg-brand-secondary-50 rounded-lg border border-brand-secondary-200">
                <img src="{{ $cover_url ?? 'default.png' }}" class="w-16 h-20 object-cover shadow">
                <div class="flex-1">
                    <h4 class="font-bold text-sm">{{ $title }}</h4>
                    <p class="text-xs text-gray-600">{{ $author }}</p>
                </div>
            </div>
        @endif


        {{-- Reading current status --}}
        <div>
            <x-input-label for="current-page" value="Reading status" class="text-lg mt-4" />
            <div class="flex flex-row items-end gap-3">
                <x-text-input id="current-page" type="text" class="mt-1 block" placeholder="current page"
                    wire:model="current_page" />
                <p class="text-lg"> / </p>
                <p class="text-lg text-gray-600">{{ $total_pages ?? 'total' }} pages</p>
            </div>

            {{-- Validation error --}}
            <div>
                @error('current_page')
                    <x-input-error :messages="$message" class="mt-2" />
                @enderror
            </div>
        </div>

        {{-- Review --}}
        <x-modal.input-textarea label="Review" id="review" name="review"
            placeholder="Write your thoughts or feedback here" />

        {{-- Save/Update button --}}
        <x-modal.submit-buttons :name="$readingLog ? 'update' : 'save'" />
    </form>

</x-modal>

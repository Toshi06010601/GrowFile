{{-- <div>
    <div x-data="{
        open: false,
        search: '',
    
    }" @click.away="open = false">

        <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
        <div class="flex flex-row gap-2">
  
            <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..." @focus="open = true"
                @keydown.escape.prevent="open = false">
            <x-secondary-button wire:click="addTag(search)" class="mt-1">Add</x-secondary-button>
        </div>

        <ul x-show="open" class="max-h-20 w-full overflow-y-auto">
            @foreach ($allTags as $tag)
                <li wire:key="allTags{{ $tag->id }}" x-show="$wire.tag.name.startsWith(search)">
                    <label>
                        <input type="checkbox" value={{ $tag->id }} wire:model="selectedTagIds"
                            wire:click="updateSelectedTags">
                        <span x-text="$wire.allTag[1]"></span>
                    </label>
                </li>
            @endforeach
        </ul>
    </div>

    <ul>
        @foreach ($selectedTags as $tag)
            <li
                wire:key="selected{{ $tag->id }}"
                class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
                <span>{{ $tag->name }}</span>
                <label class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                    wire:click="updateSelectedTags" for="selectedTag{{ $tag->id }}">
                    &times;
                </label>
                <input type="checkbox" class="hidden" wire:model="selectedTagIds" value={{ $tag->id }}
                    id="selectedTag{{ $tag->id }}">
            </li>
        @endforeach
    </ul>

</div> --}}


<div>
    <div x-data="{
        open: false,
        search: '',
        tags: @js($allTags).map(tag => ({ ...tag, show: true })),
        selected: @entangle('selectedTags'),
    
        //update x-show to hide the tags which don't match the search input
        updateSuggestion() {
            const keyword = this.search.toLowerCase();
            this.tags.forEach(tag => {
                tag.show = tag.name.toLowerCase().includes(keyword);
            });
        },
    }" 
    x-on:tag-added.window="tags.push({...$event.detail.tag, show:true });console.log(tags);selected.push($event.detail.tag['id']);console.log(selected);"
    x-on:click.away="open = false">

        <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
        <div class="flex flex-row gap-2">
            {{-- Invoke updateShow method on each input --}}
            <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..."
                x-on:input="updateSuggestion()" x-on:focus="open = true" x-on:keydown.escape.prevent="open = false">
            <x-secondary-button x-on:click="$wire.addTag(search)" class="mt-1" ::disabled="tags.some(tag => tag.name.toLowerCase() === search.toLowerCase())">Add</x-secondary-button>
        </div>

        {{-- Show tags matching the search input --}}
        <template x-for="tag in tags" :key="tag.id" x-show="open"
            class="flex flex-col max-h-20 w-full overflow-y-auto">
            <label x-show="tag.show" class="block">
                <input type="checkbox" :value="tag.id" x-model="selected">
                <span x-text="tag.name"></span>
            </label>
        </template>

         {{-- Show selected tags --}}
        <template x-for="id in selected" :key="id" class="flex flex-col max-h-20 w-full overflow-y-auto">
            <div
                class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
                <span x-text="tags.find(t => t.id == id).name"></span>
                <button class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                    x-on:click.prevent="selected = selected.filter(s => s != id)">
                    &times;
                </button>
            </div>
        </template>
    </div>

    {{-- @foreach ($selectedTags as $tag)
        <div
            class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
            <span>{{ $tag->name }}</span>
            <label class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                wire:click="updateSelectedTags" for="selectedTag{{ $tag->id }}">
                &times;
            </label>
            <input type="checkbox" class="hidden" wire:model="selectedTagIds" value={{ $tag->id }}
                id="selectedTag{{ $tag->id }}">
        </div>
    @endforeach --}}

</div>

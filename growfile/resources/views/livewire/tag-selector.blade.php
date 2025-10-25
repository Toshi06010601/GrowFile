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
        items: @js($allTags).map(tag => ({ ...tag, show: true })),
        tags: @js($allTags).map(tag => tag.name),
        selected: @entangle('selectedTagIds'),
    
        //create new Tag
        async addNewTag() {
            const newTag = await $wire.addTag(this.search);
            this.items.push({ ...newTag, show: true });
            this.tags.push(newTag.name);
            this.search = '';
            this.updateShow();
            console.log(this.items);
        },
    
        //update x-show to hide the items which don't match the search input
        updateShow() {
            const keyword = this.search.toLowerCase();
            this.items.forEach(item => {
                item.show = item.name.toLowerCase().includes(keyword);
            });
        },
    }" @click.away="open = false">

        <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
        <div class="flex flex-row gap-2">
            {{-- Invoke updateShow method on each input --}}
            <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..."
                @input="updateShow()" @focus="open = true" @keydown.escape.prevent="open = false">
            <x-secondary-button x-on:click="addNewTag()" class="mt-1" ::disabled="tags.includes(search)">Add</x-secondary-button>
        </div>

        {{-- Show items matching the search input --}}
        <template x-for="item in items" :key="item.id" x-show="open" class="flex flex-col max-h-20 w-full overflow-y-auto">
            <label x-show="item.show" class="block">
                <input type="checkbox" :value="item.id" x-model="selected"
                    x-on:click="$wire.updateSelectedTags">
                <span x-text="item.name"></span>
            </label>
        </template>
    </div>

    @foreach ($selectedTags as $tag)
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
    @endforeach

</div>

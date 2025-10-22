<div x-data="{
    open: false,
    search: '',
    tags: @js($allTags).map(tag => ({ ...tag, show: true, checked: false })),
    tagNames: @js($allTags).map(tag => tag.name),
    selectedTagIds: @js($selectedTagIds),

    //set initial checked status
    setCheckedStatus() {
        this.tags = @js($allTags).map(tag => ({ ...tag, show: true, checked: false }));
        this.tagNames = @js($allTags).map(tag => tag.name);
        this.selectedTagIds = @js($selectedTagIds);
        this.tags.forEach(tag => {
            tag.checked = this.selectedTagIds.includes(tag.id);
        });
        console.log(this.tagNames);
    },

    //update checked status
    updateCheckedStatus(id) {
        const clickedItem = this.tags.find(tag => tag.id === id);
        clickedItem.checked = !clickedItem.checked;
    },

    //create new Tag
    async addNewTag() {
        const newTag = await $wire.addTag(this.search);
        this.tags.push({ ...newTag, show: true, checked: true });
        this.tagNames.push(newTag.name);
        this.search = '';
        this.updateShow();
    },

    //update x-show to hide the items which don't match the search input
    updateShow() {
        const keyword = this.search.toLowerCase();
        this.tags.forEach(tag => {
            tag.show = tag.name.toLowerCase().includes(keyword);
        });
    },
}" x-on:initialize-tags-status.window="setCheckedStatus()" @click.away="open = false">

    <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
    <div class="flex flex-row gap-2">
        {{-- Invoke updateShow method on each input --}}
        <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..." @input="updateShow()"
            @focus="open = true" @keydown.escape.prevent="open = false">
        <x-secondary-button x-on:click="addNewTag()" class="mt-1" ::disabled="tagNames.includes(search) && search != ''">Add</x-secondary-button>
    </div>

    <ul x-show="open" class="max-h-20 w-full overflow-y-auto">
        <template x-for="tag in tags" :key="tag.id">
            {{-- Show items matching the search input --}}
            <li x-show="tag.show">
                <label>
                    <input type="checkbox" :value="tag.id" :checked="tag.checked"
                        x-on:click="updateCheckedStatus(tag.id)" wire:model.defer="selectedTagIds">
                    <span x-text="tag.name"></span>
                </label>
            </li>
        </template>
    </ul>

    <ul>
        <template x-for="tag in tags" :key="tag.id">
            <li class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200"
                :style="!tag.checked && 'display:none'">
                <span x-text="tag.name"></span>
                <label class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                    x-on:click="updateCheckedStatus(tag.id)" :for="'tag' + tag.id">
                    &times;
                </label>
                <input type="checkbox" class="hidden" :value="tag.id" :id="'tag' + tag.id">
            </li>
        </template>
    </ul>
</div>


{{-- 
<div>
    <div x-data="{
        open: false,
        search: '',
        items: @js($allTags).map(tag => ({ ...tag, show: true, checked: false })),
        tags: @js($allTags).map(tag => tag.name),

        //set checked status
    
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
            Invoke updateShow method on each input
            <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..."
                @input="updateShow()" @focus="open = true" @keydown.escape.prevent="open = false">
            <x-secondary-button wire:click="addTag(search)" class="mt-1" ::disabled="tags.includes(search) && search != ''">Add</x-secondary-button>
        </div>

        <ul x-show="open" class="max-h-20 w-full overflow-y-auto">
            <template x-for="item in items" :key="item.id">
                Show items matching the search input
                <li x-show="item.show">
                    <label>
                        
                          Add the item into selectedTagIds array when ticked, remove it when unticked. 
                          Update selectedTags array whenever ticked/unticked to keep selectedTags array in sync with selectedTagIds
                       
                        <input type="checkbox" :value="item.id" wire:model="selectedTagIds"
                            wire:click="updateSelectedTags">
                        <span x-text="item.name"></span>
                    </label>
                </li>
            </template>
        </ul>
    </div>

    @foreach ($selectedTags as $tag)
        <div
            class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
            <span>{{ $tag->name }}</span>
            Untick checkbox for the tag to be removed from selectedTagIds array, 
                  then update selectedTags array to keep it in sync with selectedTagIds
                 
            <label class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                wire:click="updateSelectedTags" for="selectedTag{{ $tag->id }}">
                &times;
            </label>
            <input type="checkbox" class="hidden" wire:model="selectedTagIds" value={{ $tag->id }}
                id="selectedTag{{ $tag->id }}">
        </div>
    @endforeach

</div> --}}

<div>
    <div x-data="{
        open: false,
        search: '',
        tags: @js($allTags).map(tag => ({ ...tag, show: true })),
        selected: @entangle('selectedTags'),
    
        //create new Tag
        async addNewTag() {
            const newTag = await $wire.addTag(this.search);
            this.tags.push({ ...newTag, show: true });
            this.search = '';
            this.updateSuggestion();
        },

        filtered() {
            return this.tags.filter(tag => this.selected.map(String).includes(String(tag.id)));
        },
    
        //update x-show to hide the tags which don't match the search input
        updateSuggestion() {
            const keyword = this.search.toLowerCase();
            this.tags.forEach(tag => {
                tag.show = tag.name.toLowerCase().includes(keyword);
            });
        },
    }"
        {{-- x-effect="selectedTags = tags.filter(tag => selected.map(String).includes(String(tag.id)));console.log(selectedTags);" --}}
        x-on:click.away="open = false">

        <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
        <div class="flex flex-row gap-2">
            {{-- Invoke updateShow method on each input --}}
            <input class="mt-1 block w-auto flex-1 rounded-md" x-model="search" placeholder="Search..."
                x-on:input="updateSuggestion()" x-on:focus="open = true" x-on:keydown.escape.prevent="open = false">
            <x-secondary-button x-on:click="addNewTag" class="mt-1" ::disabled="tags.some(tag => tag.name.toLowerCase() === search.toLowerCase())">Add</x-secondary-button>
        </div>

        {{-- Show tags matching the search input --}}
        <template x-for="tag in tags" :key="tag.id" x-show="open"
            class="flex flex-col max-h-20 w-full overflow-y-auto">
            <label x-show="tag.show" class="block">
                <input type="checkbox" :value="tag.id" x-model="selected" />
                <span x-text="tag.name"></span>
            </label>
        </template>

        {{-- Show selected tags --}}
        <template x-for="tag in filtered()" :key="tag.id"
            class="flex flex-col max-h-20 w-full overflow-y-auto">
            <div
                class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
                <span x-text="tag.name"></span>
                <button class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
                    x-on:click.prevent="selected = selected.filter(s => s != tag.id)">
                    &times;
                </button>
            </div>
        </template>
    </div>

</div>

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
    
        //Update selected Tags to show
        selectedTags() {
            return this.tags.filter(tag => this.selected.map(String).includes(String(tag.id)));
        },
    
        //create new Tag
        async addNewTag() {
            const newTag = await $wire.addTag(this.search);
            this.tags.push({ ...newTag, show: true });
            this.search = '';
            this.updateSuggestion();
        },
    }" @click.away="open = false">

        <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
        
        <div class="grid grid-cols-8 gap-1" :class="open ? 'grid-rows-3' : 'grid-rows-1'">
            {{-- Invoke updateSuggestion method on each input --}}
            <input class="row-span-1 col-span-6 sm:col-span-7 mt-1 block w-auto  rounded-md" x-model="search" placeholder="Search..."
                x-on:input="updateSuggestion()" x-on:focus="open = true" x-on:keydown.escape.prevent="open = false">

            {{-- Show tags that match the search input --}}
            <div x-show="open" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0 "
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="row-span-2 col-span-6 sm:col-span-7 flex flex-col gap-1 pl-2 border-2 border-x-gray-300 border-b-gray-300 max-h-20 w-full overflow-y-auto">
                <template x-for="tag in tags" :key="tag.id" x-show="open">
                    <label x-show="tag.show" class="block">
                        <input type="checkbox" :value="tag.id" x-model="selected" />
                        <span x-text="tag.name"></span>
                    </label>
                </template>
            </div>

            {{-- Add a new tag --}}
            <x-secondary-button x-on:click="addNewTag"
                class="row-span-1 col-span-2 col-start-7 sm:col-span-2 sm:col-start-7 row-start-1 mt-1 text-center"
                ::disabled="tags.some(tag => tag.name.toLowerCase() === search.toLowerCase()) || search.trim() === ''">Add</x-secondary-button>
        </div>

        {{-- Show selected tags --}}
        <template x-for="tag in selectedTags()" :key="tag.id"
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

<div>
    <div 
      x-data="{
        open: false,
        search: '',
    
        items: @js($allTags),
    
        get filteredItems() {
            return this.items.filter(
                item => item.name.toLowerCase().startsWith(this.search.toLowerCase())
            )
        }
      }" 
    @click.away="open = false"
    >
    <button wire:click="showSelectedTagIds">click here</button>
            <x-input-label for="tag" value="Tag" class="text-lg mt-4" />
            <input class="mt-1 block w-full rounded-md" x-model="search" placeholder="Search..." @focus="open = true"
                @keydown.escape.prevent="open = false">

            <ul x-show="open" class="max-h-20 w-full overflow-y-auto">
                <template x-for="item in filteredItems" :key="item.id">
                    <li>
                      <label>
                        <input 
                          type="checkbox"
                          :value="item.id"
                          wire:model="selectedTagIds"
                        >
                        <span x-text="item.name"></span> 
                      </label>
                    </li>
                </template>
            </ul>
    </div>

  @foreach ($selectedTags as $selectedTag)
      <div class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200">
          <span>{{ $selectedTag->name }}</span>
            <button
              class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none"
              wire:click="removeTag({{ $selectedTag->id }})"
            >
            &times;
            </button>
      </div>
  @endforeach

</div>

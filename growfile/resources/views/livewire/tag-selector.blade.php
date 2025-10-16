<div>
    <div x-data="open: true" @click.away="open = false">
        <form wire:submit.prevent="addTag" class="flex flex-row gap-1">
            <x-input-label for="search-tag" value="Tags" class="text-lg mt-4" />
            <x-text-input 
                id="search-tag" 
                type="text" 
                class="mt-1 block w-auto" placeholder="Search and select tag"
                wire:model="searchedTag" 
                @focus="open = true"
                @keydown.escape.prevent="open = false"
                />
            <x-secondary-button>Add</x-secondary-button>
            <x-input-error :messages="$customError" class="mt-2" />

            <ul 
                x-show="open" 
                class="max-h-10 overflow-y-auto"
            >
                @foreach ($allTags as $tag)
                    <li 
                        {{-- wire:click="selectTag({{ $tag->id }})" --}}
                        @click="open = false"
                    >
                        {{ $tag->name }}
                    </li>
                @endforeach
            </ul>
        </form>
    </div>

    @foreach ($selectedTags as $selectedTag)
        <label
            class="inline-flex justify-around select-none min-w-12 align-middle px-1 py-1 m-1 rounded-md bg-black text-sm text-white cursor-pointer hover:bg-gray-700 transition-all duration-200"><input
                type="checkbox" class="hidden" wire:model="selectedTag[]">{{ $selectedTag }} <button
                class="font-bold ml-1 text-white bg-none border-none cursor-pointer text-sm leading-none">&times;</button>
        </label>
    @endforeach
</div>


{{-- 
/* Search suggestion section */
.suggestion-list {
  display: flex;
  flex-direction: column;
}

.suggestion-item {
  transition: transform 0.5s, opacity 0.5s;
  border: solid 2px black;
  border-bottom: none; 
}

.suggestion-item:last-child {
 border-bottom: solid 2px black;
}

.suggestion-item:hover {
   transform: scale(1.1);
   opacity: 0.8;
   border-bottom: solid 2px black;
   cursor: pointer;
}


// When filtering option by type
export const setTypesInCombobox = (types) => {
  let htmlData = "";
  htmlData += types.map(type => {
    return `<option value="${type.name}">${type.name}</option>`
  });
  document.querySelector("#js-types").innerHTML = htmlData;
}

// When showing suggestions for user's input
export const getMatchingPokemons = (pokemons, currentInput) => {
  const matchedPokeNames = currentInput != "" ? pokemons.filter(pokemon => pokemon.pokemon.name.startsWith(currentInput)) : [];
  const firstFiveMatches = matchedPokeNames.slice(0, 5);
  return firstFiveMatches;
}

export const showSuggestions = (pokeNames) => {
  // Construct html for suggestions and insert
  let htmlData = pokeNames
  .map(pokeName => {
    return `<div class="suggestion-item">${pokeName.pokemon.name}</div>`;
  })
  .join("");
  htmlData = `<div class="suggestion-list">${htmlData}</div>`
  document.querySelector("#js-result").innerHTML = htmlData;

  // Add event listener for each suggestion to enable form submission upon click
  document.querySelectorAll(".suggestion-item")
  .forEach(suggestion => {
    // Play sound when a mouse hover over the suggestion
    suggestion.addEventListener("mouseover", (e)=>{
      const hoverSound = new Audio("/hover_sound.mp3");
      hoverSound.currentTime = 0;
      hoverSound.play();
    })

    // 
    suggestion.addEventListener("click", (e) => {
      // Play select sound
      const selectSound = new Audio("/select_sound.mp3");
      selectSound.play();

      // Fill out the input field and submit
      const $form = document.querySelector("#js-form");
      $form.elements.pokeName.value = e.target.textContent;
      $form.elements.submitBtn.click();
    });
  })

} --}}

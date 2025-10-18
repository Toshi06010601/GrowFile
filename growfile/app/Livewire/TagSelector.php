<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
// use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;

class TagSelector extends Component
{
    public $allTags;

    // #[Modelable]
    public $selectedTagIds = [];

    public $selectedTags = [];

    /*
    Public function for the tag selector
    */
    public function mount()
    {
        $this->loadAllTags();
        // $this->selectedTags = $this->allTags->whereIn('id', $this->selectedTagIds);
        // $this->selectedTagIds = array_column($this->selectedTags, 'id');
        // $count = count($this->selectedTagIds);
        // $this->js("console.log('Selected Tag Ids:', $count);");
    }

    // public function boot() {
        // $this->selectedTags = $this->allTags->whereIn('id', $this->selectedTagIds);
        //   $count = count($this->selectedTagIds);
        //   $this->js("console.log('Selected Tag Ids:', $count);");
        //     $count = count($this->selectedTags);
        //   $this->js("console.log('Selected Tags:', $count);");
    // }

    public function loadAllTags()
    {
        $this->allTags = Tag::orderBy('name')->get();
    }

    #[On('set-selected-tags')]
    public function setSelectedTags($tagIds = [])
    {
        // $this->js("console.log('Selected Tags:', $key, $value);");
        // $this->js("console.log('fired');");
        $this->selectedTagIds = $tagIds;
        $this->selectedTags = $this->allTags->whereIn('id', $tagIds);
    }


    public function updateSelectedTags()
    {
        // $this->js("console.log('Selected Tags:', $value);");
        $this->js("console.log('fired');");
        $this->selectedTags = $this->allTags->whereIn('id', $this->selectedTagIds);
    }

    public function removeTag(int $id)
    {
        $this->selectedTagIds = collect($this->selectedTagIds)
        // 1. REJECT: Filter out (reject) the element whose value strictly matches the $id.
        ->reject(fn($tagId) => $tagId === $id)
        
        // 2. VALUES: Re-index the array keys to be sequential (0, 1, 2...).
        ->values() 
        
        // 3. TO ARRAY: Convert the Collection back to a standard PHP array.
        ->toArray();
    }

    // public function updateUnSelectedTags()
    // {
    //     //Get ID column only
    //     $selectedIds = array_column($this->selectedTags, 'id');
    //     //Filter out selectedTags to create unSelectedTags array
    //     $this->unSelectedTags = array_filter($this->allTags, function($tag) use ($selectedIds) {
    //         return !in_array($tag['id'], $selectedIds);
    //     });
    // }

    // public function selectTag($id)
    // {
    //     //Add the target tag to selectedTags
    //     $this->selectedTags[] = Tags::findOrFail($id);
    //     //Get ID column only
    //     $selectedIds = array_column($this->selectedTags, 'id');
    //      //Filter out selectedTags to create unSelectedTags array
    //     $this->unSelectedTags = array_filter($this->allTags, function($tag) use ($selectedIds) {
    //         return !in_array($tag['id'], $selectedIds);
    //     });
    // }

    // public function unSelectTag($id)
    // {
    //     //Filter out the target tag from the current selectTags
    //     $this->selectedTags = array_filter($this->selectTags, function($tag) use ($id) {
    //         return $tag['id'] != $id;
    //     });
    //     //Get ID column only
    //     $selectedIds = array_column($this->selectedTags, 'id');
    //     //Filter out selectedTags to create unSelectedTags array
    //     $this->unSelectedTags = array_filter($this->allTags, function($tag) use ($selectedIds) {
    //         return !in_array($tag['id'], $selectedIds);
    //     });
    // }


    public function render()
    {
        return view('livewire.tag-selector');
    }
}

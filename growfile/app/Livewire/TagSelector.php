<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\Modelable;

class TagSelector extends Component
{
    public $allTags;

    public $selectedTagIds = [];

    #[Modelable]
    public $selectedTags = [];

    /*
    Public function for the tag selector
    */
    public function mount()
    {
        $this->loadAllTags();
    }

    // public function booted()
    // {
    //     $this->js("console.log('Selected Tag Ids:', $this->selectedTagIds);");
    // }

    public function loadAllTags()
    {
        $this->allTags = Tag::orderBy('name')->get();
    }

    public function updatedSelectedTagIds()
    {
        $this->selectedTags = $this->allTags->whereIn('id', $selectedTagIds);
    }

    public function showSelectedTagIds()
    {
        $this->js("console.log('Selected Tags:', $this->selectedTags);");
    }

    public function removeTags(int $id)
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

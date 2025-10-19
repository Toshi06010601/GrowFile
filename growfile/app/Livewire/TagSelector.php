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
    }

    public function loadAllTags()
    {
        $this->allTags = Tag::orderBy('name')->get();
    }

    #[On('set-selected-tags')]
    public function setSelectedTags($tagIds = [])
    {
        $this->selectedTagIds = $tagIds;
        $this->selectedTags = $this->allTags->whereIn('id', $tagIds);
    }

    public function updateSelectedTags()
    {
        $this->selectedTags = $this->allTags->whereIn('id', $this->selectedTagIds);
    }

    public function render()
    {
        return view('livewire.tag-selector');
    }
}

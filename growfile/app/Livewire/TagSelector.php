<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagSelector extends Component
{
    public $allTags = [];
    public $selectedTags = ['111', '222'];
    public $searchedTag = '';
    public $customError = '';

    /*
    Public function for the tag selector
    */
    public function mount()
    {
        $this->loadTags();
    }

    public function loadTags()
    {
        $this->allTags = Tag::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.tag-selector');
    }
}

<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TagSelector extends Component
{
    public $allTags;

    public $selectedTagIds = [];

    public $selectedTags = [];

    public $studyRecordId;

    /*
    Public function for the tag selector
    */
    public function mount()
    {
        $this->loadAllTags();
    }

    public function loadAllTags()
    {
        $this->allTags = Tag::where('user_id', auth()->id())->orderBy('name')->get();
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

    public function addTag($tagName)
    {
        if(!$this->selectedTags->contains('name', $tagName)) {
            $newTag = Tag::create([
                            'user_id' => Auth::id(),
                            'name' => $tagName
                        ]);
        }

        return $newTag;
    }


    public function render()
    {
        return view('livewire.tag-selector');
    }
}

<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class TagSelector extends Component
{
    public $allTags;

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
        $this->allTags = Tag::where('user_id', auth()->id())->orderBy('name')->get();
    }

    #[On('set-selected-tags')]
    public function setSelectedTags($tagIds = [])
    {
        $this->selectedTags = $tagIds;
    }

    public function addTag($tagName)
    {
        $newTag = Tag::create([
                        'user_id' => Auth::id(),
                        'name' => $tagName
                    ]);

        $this->loadAllTags();

        $this->dispatch('tag-added', tag: $newTag);

    }


    public function render()
    {
        return view('livewire.tag-selector');
        //         return view('livewire.tag-selector', [
        //     'tags' => $this->allTags->toArray(),
        // ]);
;
    }
}


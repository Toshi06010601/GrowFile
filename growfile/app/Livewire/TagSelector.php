<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;

class TagSelector extends Component
{
    public $allTags;

    #[Modelable]
    public $selectedTags = [];

    public function mount()
    {
        $this->loadAllTags();
    }
    
    /*
    Retrieve all the tags created by the users and store id and name into allTags
    */
    public function loadAllTags()
    {
        $this->allTags = Tag::where('user_id', auth()->id())
                        ->orderBy('name')
                        ->get()
                        ->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name]);;
    }
    
    /*
    Create a new tag
    */
    public function addTag($tagName)
    {
        $newTag = Tag::firstOrCreate([
                        'user_id' => Auth::id(),
                        'name' => $tagName
                    ]);

        //Add it into selectedTags array
        $this->selectedTags[] = $newTag->id;

        //Pass it to the view file
        return [
            'id' => $newTag->id,
            'name' => $newTag->name,
        ];
    }

    public function render()
    {
        return view('livewire.tag-selector');
;
    }
}


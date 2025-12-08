<?php
namespace App\Livewire\Profile\Partials;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;

class TagSelector extends Component
{
    /*
    Public variables 
    */
    public $allTags;

    #[Modelable]
    public $selectedTags = [];


    /*
    Public functions 
    */
    public function mount()
    {
        $this->loadAllTags();
    }
    
    public function loadAllTags()
    {
        // Retrieve all the tags created by the current user and store id and name into allTags
        $this->allTags = Tag::where('user_id', Auth::id())
                        ->orderBy('name')
                        ->get()
                        ->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name]);;
    }
    
    public function addTag($tagName)
    {
        // 1. Create a new tag if it doesn't already exist
        $newTag = Tag::firstOrCreate([
                        'user_id' => Auth::id(),
                        'name' => $tagName
                    ]);

        // 2. Add it into selectedTags array
        if (!in_array($newTag->id, $this->selectedTags)) {
            $this->selectedTags[] = $newTag->id;
        }

        // 3. Pass it to the view file
        return [
            'id' => $newTag->id,
            'name' => $newTag->name,
        ];
    }

    public function render()
    {
        return view('livewire.profile.partials.tag-selector');
;
    }
}


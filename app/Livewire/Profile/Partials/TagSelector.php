<?php
namespace App\Livewire\Profile\Partials;

use Livewire\Component;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;
use Exception;

class TagSelector extends Component
{
    /*
    Public variables 
    */
    #[Modelable]
    public $selectedTags = [];
    public $hasError = false;

    /*
    Public functions
    */
    #[Computed]
    public function allTags()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading all tags', ['profileUserId' => Auth::id()]);
            $this->hasError = false;
            // Retrieve all the tags created by the current user and store id and name into allTags
            return Tag::where('user_id', Auth::id())
                        ->orderBy('name')
                        ->get()
                        ->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name]);;
        } catch (Exception $e) {
            logger()->error('Failed to load all tags', ['profileUserId' => Auth::id(), 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    public function addTag($tagName)
    {
        try {
            // 1. Create a new tag if it doesn't already exist
            $newTag = Tag::firstOrCreate([
                'user_id' => Auth::id(),
                'name' => $tagName
            ]);

            
            // 2. Add it into selectedTags array
            if (!in_array($newTag->id, $this->selectedTags)) {
                $this->selectedTags[] = $newTag->id;
            }

            logger()->info('Added a tag', ['tagName' => $tagName, 'profileUserId' => Auth::id()]);
    
            unset($this->allTags);

            // 3. Pass it to the view file
            return [
                'id' => $newTag->id,
                'name' => $newTag->name,
            ];
        } catch (Exception $e) {
            logger()->error('Failed to add tag', [
                'tagName' => $tagName,
                'error' => $e->getMessage()
            ]);
            return $e;
        }
    }

    public function render()
    {
        return view('livewire.profile.partials.tag-selector');
    }
}


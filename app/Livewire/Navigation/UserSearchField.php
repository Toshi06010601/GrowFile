<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use App\Models\Profile;
use Livewire\Attributes\Validate;

class UserSearchField extends Component
{
    /*
    Declare variables
    */
    #[Validate('required|string|max:100')]
    public $search = '';
    public $suggestions = [];

    public function updatedSearch()
    {
        if($this->search === '' || strlen($this->search) > 1){
            $this->suggestions = [];
            return;
        }

        // 1. validate search word
        $validated = $this->validate();

        // 2. Sanitize search term
        $searchTerm = str_replace(['%', '_'], ['\%', '\_'], strtolower($validated['search']));

        // 3. Query database directly with LIMIT
        $this->suggestions = Profile::select('full_name', 'profile_image_path', 'headline', 'slug')
                            ->whereLike('full_name', $searchTerm . '%')
                            ->where('visibility', true)
                            ->orderBy('full_name')
                            ->limit(10)
                            ->get()
                            ->toArray();
    }

    public function render()
    {
        return view('livewire.navigation.user-search-field');
    }
}

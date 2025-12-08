<?php

namespace App\Livewire\Navigation;

use Livewire\Component;
use App\Models\Profile;

class UserSearchField extends Component
{
    /*
    Declare variables
    */
    public $profiles = [];
    public $search = '';
    public $suggestions = [];

    public function mount()
    {
        $this->loadProfiles();
    }

    public function loadProfiles()
    {
        // Get all the visible profiles 
        $this->profiles = Profile::select('id', 'full_name', 'profile_image_path', 'headline', 'slug')
                            ->where('visibility', true)
                            ->orderBy('full_name')
                            ->get();
    }

    public function updatedSearch()
    {
        // 1. Initialize filtered
        $filtered = collect();

        // 2. If search word exists, filter all the profiles based on search word
        if($this->search) {
            $filtered = $this->profiles
                        ->filter(function ($profile) {
                            return str_starts_with(strtolower($profile->full_name), strtolower($this->search));
                        });
        }

        // 3. Update suggestions with filtered values
        $this->suggestions = $filtered->values()->all();
    }

    public function render()
    {
        return view('livewire.navigation.user-search-field');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile;

class UserSearchField extends Component
{
    public $profiles = [];

    public $search = '';

    public $suggestions = [];

    public function mount()
    {
        $this->loadProfiles();
    }

    public function loadProfiles()
    {
        $this->profiles = Profile::select('id', 'full_name', 'profile_image_path', 'headline', 'slug')
                            ->where('visibility', true)
                            ->orderBy('full_name')
                            ->get();
    }

    public function updatedSearch()
    {
        $filtered = collect();

        if($this->search) {
            $filtered = $this->profiles
                        ->filter(function ($profile) {
                            return str_starts_with(strtolower($profile->full_name), strtolower($this->search));
                        });
        } else {
            $filtered = collect([]);
        }

        $this->suggestions = $filtered->values()->all();
    }

    public function render()
    {
        return view('livewire.user-search-field');
    }
}

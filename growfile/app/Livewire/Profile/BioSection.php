<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BioSection extends Component
{
    public $profile;
    public $profileId;

    /*
    Public function for the section area
    */
    public function mount($profileId)
    {
        $this->profileId = $profileId;
        $this->loadBio();
    }

    #[On('load-bio')]
    public function loadBio()
    {
        $this->profile = Profile::select('id', 'user_id', 'bio')
                        ->find($this->profileId);
    }

    public function render()
    {
        return view('livewire.profile.bio-section');
    }
}

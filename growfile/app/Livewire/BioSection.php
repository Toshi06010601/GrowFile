<?php

namespace App\Livewire;

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
            // For debug
        // $id = Auth::id();
        // $this->js("console.log($id);");
        // $user_id = $this->profile->user_id;
        // $this->js("console.log($user_id);");
    }

    #[On('load-bio')]
    public function loadBio()
    {
        $this->profile = Profile::select('id', 'user_id', 'bio')
                        ->find($this->profileId);
    }

    public function render()
    {
        return view('livewire.bio-section');
    }
}

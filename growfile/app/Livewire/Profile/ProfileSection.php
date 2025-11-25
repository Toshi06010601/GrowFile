<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileSection extends Component
{

    public $profile;
    public $profileId;

    /*
    Public function for the section area
    */
    public function mount($profileId)
    {
        $this->profileId = $profileId;

        $this->loadResult();
    }

    #[On('load-profile')]
    public function loadResult()
    {
        $this->profile = Profile::find($this->profileId);
    }

    public function render()
    {
        return view('livewire.profile.profile-section');
    }
}

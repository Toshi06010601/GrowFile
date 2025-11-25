<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class BackgroundSection extends Component
{
    public $profile;
    public $profileId;

    /*
    Public function for the section area
    */
    public function mount($profileId)
    {
        $this->profileId = $profileId;
        $this->loadBackground();
    }

    #[On('load-background')]
    public function loadBackground()
    {
        $this->profile = Profile::select('id', 'background_image_path', 'user_id')
                        ->find($this->profileId);
    }

    public function render()
    {
        return view('livewire.profile.background-section');
    }
}

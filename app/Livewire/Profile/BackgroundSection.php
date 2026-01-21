<?php

namespace App\Livewire\Profile;

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
        logger('🔄 loadBackground called', ['profileId' => $this->profileId]);
        // Get the profile with the background image
        $this->profile = Profile::select('id', 'background_image_path', 'user_id')
                        ->find($this->profileId);
    }

    public function render()
    {
        return view('livewire.profile.background-section');
    }
}

<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class BackgroundSection extends Component
{
    public $profile;
    public $userId;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadBackground();
    }

    #[On('load-background')]
    public function loadBackground()
    {
        logger()->info('🔄 loadBackground called', ['profileUserId' => $this->userId]);
        // Get the profile with the background image
        $this->profile = Profile::select('id', 'background_image_path', 'user_id')
                        ->firstWhere('user_id', $this->userId);
    }

    public function render()
    {
        return view('livewire.profile.background-section');
    }
}

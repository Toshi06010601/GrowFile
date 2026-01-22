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
    /*
    Public variables for the section area
    */
    public $profile;
    public $userId;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadResult();
    }

    #[On('load-profile')]
    public function loadResult()
    {
        logger()->info('🔄 loadProfile called', ['profileUserId' => $this->userId]);

        // Get profile data together with following status
        $this->profile = Profile::with('user.authFollows')->firstWhere('user_id', $this->userId);
    }

    public function render()
    {
        return view('livewire.profile.profile-section');
    }
}

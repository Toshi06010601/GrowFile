<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProfileSection extends Component
{
    /*
    Public variables for the section area
    */
    #[Locked]
    public $userId = null;
    public $hasError = false;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
    }

    #[Computed] 
    public function profile()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading profile', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            // Get the profile with the profile image
            return Profile::with('user.authFollows')->firstWhere('user_id', $this->userId);
        } catch (Exception $e) {
            logger()->error('Failed to load profile', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('profile-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching profile', ['profileUserId' => $this->userId]);
        unset($this->profile); // Refresh profile
    }

    public function render()
    {
        $this->profile;
        return view('livewire.profile.profile-section');
    }
}


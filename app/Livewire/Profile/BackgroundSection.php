<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class BackgroundSection extends Component
{
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
            logger()->info('🔄 loading background', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            // Get the profile with the background image
            return Profile::select('id', 'background_image_path', 'user_id')
                        ->firstWhere('user_id', $this->userId);
        } catch (Exception $e) {
            logger()->error('Failed to load background', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('background-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching background', ['profileUserId' => $this->userId]);
        unset($this->profile); // Refresh background
    }

    public function render()
    {
        $this->profile;
        return view('livewire.profile.background-section');
    }
}

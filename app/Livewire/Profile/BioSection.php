<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class BioSection extends Component
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
            logger()->info('🔄 loading bio', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            // Get the profile with the bio image
            return Profile::select('id', 'user_id', 'bio')
                        ->firstWhere('user_id', $this->userId);
        } catch (Exception $e) {
            logger()->error('Failed to load bio', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('bio-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching bio', ['profileUserId' => $this->userId]);
        unset($this->bio); // Refresh bio
    }

    public function render()
    {
        $this->profile;
        return view('livewire.profile.bio-section');
    }
}


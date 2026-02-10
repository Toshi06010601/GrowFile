<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Experience;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class ExperiencesSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $hasError = false;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
    }

    #[Computed] 
    public function experiences()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading experiences', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return Experience::where('user_id', $this->userId)
                            ->orderByDesc('start_month')
                            ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load experiences', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('experiences-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching experiences', ['profileUserId' => $this->userId]);
        unset($this->experiences); // Refresh experiences
    }

    public function render()
    {
        $this->experiences;
        return view('livewire.profile.experiences-section');
    }
}


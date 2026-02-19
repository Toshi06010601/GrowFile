<?php

namespace App\Livewire\Portfolio;

use Livewire\Component;
use App\Models\Portfolio;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class PortfolioSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $lastUpdated = null;
    public $hasError = false;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->lastUpdated = now()->timestamp;
    }

    #[Computed] 
    public function portfolios()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading portfolios', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return Portfolio::where('user_id', $this->userId)
                                ->orderByDesc('updated_at')
                                ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load portfolios', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('portfolios-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching portfolios', ['profileUserId' => $this->userId]);
        $this->lastUpdated = now()->timestamp; // Refresh splide instance
        unset($this->portfolios); // Refresh portfolios
    }

    public function render()
    {
        $this->portfolios;
        return view('livewire.portfolio.section');
    }
}

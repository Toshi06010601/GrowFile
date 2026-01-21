<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Portfolio;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;


class PortfolioSection extends Component
{
    public $userId;
    public $portfolios;
    public $isOwner;
    public $lastUpdated;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->lastUpdated = now()->timestamp;
        $this->loadPortfolios();
    }

    #[On('load-portfolios')]
    public function loadPortfolios() {
        logger()->info('🔄 loadPortfolios called', ['profileUserId' => $this->userId]);
        $this->portfolios = Portfolio::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
        $this->lastUpdated = now()->timestamp;
    }

    public function render()
    {
        return view('livewire.profile.portfolio-section');
    }
}

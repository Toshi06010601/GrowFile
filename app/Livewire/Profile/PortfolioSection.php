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

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadPortfolios();
    }

    #[On('load-portfolios')]
    public function loadPortfolios() {
        $this->portfolios = Portfolio::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.portfolio-section');
    }
}

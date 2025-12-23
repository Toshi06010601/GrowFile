<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudyDashboard extends Component
{
    public $currentView = 'diary';
    public $userId;
    public $isOwner;

    public function mount($userId) 
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
    }


    public function render()
    {
        return view('livewire.profile.study-dashboard');
    }
}

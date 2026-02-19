<?php

namespace App\Livewire\StudyRecord;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudyRecordDashboard extends Component
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
        return view('livewire.study-record.dashboard');
    }
}

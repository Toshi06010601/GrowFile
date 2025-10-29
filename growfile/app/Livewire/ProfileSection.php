<?php

namespace App\Livewire;
use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;

class ProfileSection extends Component
{

    public $profile = [];

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadResult();
    }

    #[On('load-profile')]
    public function loadResult()
    {
        $this->records = StudyRecord::with('tags')
            ->where('user_id', Auth::id())
            ->orderByDesc('start_datetime')
            ->get();
    }

    public function render()
    {
        return view('livewire.profile-section');
    }
}

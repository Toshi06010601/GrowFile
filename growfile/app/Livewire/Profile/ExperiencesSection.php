<?php

namespace App\Livewire\Profile;

use App\Models\Experience;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExperiencesSection extends Component
{

    public $experiences;
    public $userId;
    public $isOwner;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadExperiences();
    }

    #[On('load-experiences')]
    public function loadExperiences()
    {
        $this->experiences = Experience::where('user_id', $this->userId)
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.experiences-section');
    }
}

<?php

namespace App\Livewire\Profile;

use App\Models\Experience;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExperiencesSection extends Component
{
    /*
    Public varialbes for the section area
    */
    public $experiences;
    public $userId;
    public $isOwner;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId; // Find out if the user is the owner of the experience record
        $this->loadExperiences();
    }

    #[On('load-experiences')]
    public function loadExperiences()
    {
        // Get experience records
        $this->experiences = Experience::where('user_id', $this->userId)
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.experiences-section');
    }
}

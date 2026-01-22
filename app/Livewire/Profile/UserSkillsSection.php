<?php

namespace App\Livewire\Profile;

use App\Models\UserSkill;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class UserSkillsSection extends Component
{
    public $userSkills;
    public $userId;
    public $isOwner;
    public $numOfSkills = 5;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId; //Check if the user is the owner
        $this->loadUserSkill();
    }

    #[On('load-user-skills')]
    public function loadUserSkill()
    {
        logger()->info('🔄 loadUserSkills called', ['profileUserId' => $this->userId]);

        // Get all the userskill records of the selected user
        $this->userSkills = UserSkill::with('skill')
                            ->where('user_id', $this->userId)
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.user-skills-section');
    }
}

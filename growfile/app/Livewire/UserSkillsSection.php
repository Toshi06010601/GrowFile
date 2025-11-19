<?php

namespace App\Livewire;

use App\Models\UserSkill;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class UserSkillsSection extends Component
{
    public $userSkills;
    public $userId;
    public $isOwner;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadUserSkill();
    }

    #[On('load-user-skills')]
    public function loadUserSkill()
    {
        $this->userSkills = UserSkill::with('skill')
                            ->where('user_id', $this->userId)
                            ->get();
    }

    public function render()
    {
        return view('livewire.user-skills-section');
    }
}

<?php

namespace App\Livewire\UserSkill;

use Livewire\Component;
use App\Models\UserSkill;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserSkillSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $hasError = false;
    public $numOfSkills = 5;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId; //Check if the user is the owner
    }

    #[Computed] 
    public function userSkills()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading user skills', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return UserSkill::with('skill')
                            ->where('user_id', $this->userId)
                            ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load user skills', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('user-skills-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching user skills', ['profileUserId' => $this->userId]);
        unset($this->userSkills); // Refresh userSkills
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
        $this->userSkills;
        return view('livewire.user-skill.section');
    }
}

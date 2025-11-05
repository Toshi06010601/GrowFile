<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class SkillSection extends Component
{
    public $user;
    public $userSkills;

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadResult();
    }

    #[On('load-skill')]
    public function loadResult()
    {
        $this->user = User::with('userSkills.skill')->find(Auth::id());
        $this->userSkills = $this->user->userSkills;
    }

    public function render()
    {
        return view('livewire.skill-section');
    }
}

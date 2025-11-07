<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Skill;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;

class SkillSelector extends Component
{
    public $skills = [];

    #[Modelable]
    public $skill_id;

    public function mount()
    {
        $this->loadAllSkills();
    }
    
    /*
    Retrieve all the tags created by the users and store id and name into allTags
    */
    public function loadAllSkills()
    {
        $this->skills = Skill::all();
    }

    public function render()
    {
        return view('livewire.skill-selector');
    }
}

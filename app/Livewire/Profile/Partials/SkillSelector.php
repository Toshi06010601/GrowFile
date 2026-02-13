<?php

namespace App\Livewire\Profile\Partials;

use Livewire\Component;
use App\Models\Skill;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Computed;
use Exception;

class SkillSelector extends Component
{
    /*
    Public variables
    */
    #[Modelable]
    public $skill_id;
    public $hasError = false;

    /*
    Public functions
    */

    #[Computed]
    public function Skills()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading skills');
            $this->hasError = false;
            return Skill::all();
        } catch (Exception $e) {
            logger()->error('Failed to load skills', ['error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }

    public function refetch() {
        logger()->info('🔄 Refetching skills');
        unset($this->skills); // Refresh skills
    }

    public function render()
    {
        return view('livewire.profile.partials.skill-selector');
    }
}

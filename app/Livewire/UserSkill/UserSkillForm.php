<?php

namespace App\Livewire\UserSkill;

use App\Models\UserSkill;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Exception;

class UserSkillForm extends Form
{
    public ?UserSkill $userSkill = null;

    /*
    Public variables for user skill model
    */
    public $skill_id = 0;
    public $level = 1;

    /*
    Public functions for the modal form
    */
    public function setFields($id)
    {
        $this->resetValidation();

        $userSkill = UserSkill::with('skill')->findOrFail($id);
        $this->userSkill    = $userSkill;
 
        $this->fill([
                ...$userSkill->only('level', 'skill_id')
            ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate the data (Rule to make sure the uniqueness of skillId which belongs to the user)
            $this->validate([
                'skill_id' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('user_skills', 'skill_id')
                    ->where('user_id', Auth::id())
                ],
                'level' => 'required|integer|min:1|max:5',
            ], [
                // Custom validation messages
                'skill_id.min' => 'Please choose both category and skill.',
                'skill_id.unique' => 'You have existing record for this skill.',
            ]);

            // 2. Create new userSkill
            UserSkill::create(
                $this->only('level', 'skill_id') 
                + 
                ['user_id' => Auth::id()]
            );
     
        });
    }

    public function update()
    {
        DB::transaction(function ()
        {
            // 1. Validate the data (Rule to make sure the uniqueness of skillId which belongs to the user)
            $this->validate([
                'skill_id' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('user_skills', 'skill_id')
                    ->where('user_id', Auth::id())
                    ->ignore($this->userSkill) //Ignore the current userskill from uniquness check
                ],
                'level' => 'required|integer|min:1|max:5',
            ], [
                // Custom validation messages
                'skill_id.min' => 'Please choose both category and skill.',
                'skill_id.unique' => 'You have existing record for this skill.',
            ]);

            // 2. Update userSkill
            $this->userSkill->update(
                $this->only('level', 'skill_id') 
            );
     
        });
    }

}


<?php

namespace App\Livewire\Profile;

use App\Models\UserSkill;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UserSkillForm extends Component
{
    public ?UserSkill $userSkill;

    /*
    Public variables for user skill model
    */
    public $skill_id;

    public $level = 1;

    /*
    Public functions for the modal form
    */    
    #[On('set-user-skill')]
    public function setUserSkill($id)
    {
        if($id) {
            $userSkill          = UserSkill::with('skill')->findOrFail($id);
            $this->userSkill    = $userSkill;
            $this->level        = $userSkill->level;
            $this->skill_id     = $userSkill->skill_id;
        } else {
            $this->reset();
        }

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-user-skill');
        $this->dispatch('trigger-category-init', [
            'skillId' => $this->skill_id
        ]);
    }

    public function save()
    {
        //Validate the data
        $validatedData = $this->validate([
            'skill_id' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('user_skills', 'skill_id')
                ->where('user_id', Auth::id())
            ],
            'level' => 'required|integer|min:1|max:5',
        ], [
            'skill_id.min' => 'Please choose both category and skill.',
            'skill_id.unique' => 'You have existing record for this skill.',
        ]);

        $validatedData['user_id'] = Auth::id();

        //Create new userskill
        $this->userSkill = UserSkill::create($validatedData);

        //Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');

    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->userSkill);
        $validatedData = $this->validate([
            'skill_id' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('user_skills', 'skill_id')
                ->where('user_id', Auth::id())
                ->ignore($this->userSkill)
            ],
            'level' => 'required|integer|min:1|max:5',
        ], [
            'skill_id.min' => 'Please choose both category and skill.',
            'skill_id.unique' => 'You have existing record for this skill.',
        ]);

        //Add user id
        $validatedData['user_id'] = Auth::id();

        //Create new userskill
        $this->userSkill->update($validatedData);

        //Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');
    }

    public function delete()
    {
        //Authorize the data
        $this->authorize('delete', $this->userSkill);

        //Delete the record
        $this->userSkill->delete();

        //Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');
    }

    public function render()
    {
        return view('livewire.profile.user-skill-form');
    }
}

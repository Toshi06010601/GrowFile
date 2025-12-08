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
        // 1. If id is passed, find the userskill and assign each field to public variables 
        if($id) {
            $userSkill          = UserSkill::with('skill')->findOrFail($id);
            $this->userSkill    = $userSkill;
            $this->level        = $userSkill->level;
            $this->skill_id     = $userSkill->skill_id;
        } else {
            $this->reset();
        }

        // 2. Reset validation
        $this->resetValidation();

        // 3. Open userskill modal
        $this->dispatch('open-modal', 'edit-user-skill');

        // 4. Trigger category initialize method with the current skillId 
        $this->dispatch('trigger-category-init', [
            'skillId' => $this->skill_id
        ]);
    }

    public function save()
    {
        // 1. Validate the data (Rule to make sure the uniqueness of skillId which belongs to the user)
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
            // Custom validation messages
            'skill_id.min' => 'Please choose both category and skill.',
            'skill_id.unique' => 'You have existing record for this skill.',
        ]);

        // 2. Add user Id
        $validatedData['user_id'] = Auth::id();

        // 3. Create new userskill
        $this->userSkill = UserSkill::create($validatedData);

        // 4. Refresh User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');

    }

    public function update()
    {
        // 1. Authorize
        $this->authorize('update', $this->userSkill);

        // 2. Validate the data (Rule to make sure the uniqueness of skillId which belongs to the user)
        $validatedData = $this->validate([
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

        // 3. Add user id
        $validatedData['user_id'] = Auth::id();

        // 4. Create new userskill
        $this->userSkill->update($validatedData);

        // 5. Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        // 6. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->userSkill);

        // 2. Delete the record
        $this->userSkill->delete();

        // 3. Refresh User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillsSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');
    }

    public function render()
    {
        return view('livewire.profile.user-skill-form');
    }
}

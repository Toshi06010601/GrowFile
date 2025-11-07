<?php

namespace App\Livewire;

use App\Models\UserSkill;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UserSkillForm extends Component
{
    public ?UserSkill $userSkill;

    /*
    Public variables for user skill model
    */
    #[Validate('required|integer')]    
    public $skill_id;

    #[Validate('required|integer')]
    public $level = 0;

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
    }

       public function save()
    {
        //Validate the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();

        //Create new userskill
        $this->userSkill = UserSkill::create($validatedData);

        //Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-user-skill');

    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->userSkill);
        $validatedData = $this->validate();

        //Add user id
        $validatedData['user_id'] = Auth::id();

        //Create new userskill
        $this->userSkill->update($validatedData);

        //Reflect the updates in User Skill section
        $this->dispatch('load-user-skills')->to(UserSkillSection::class);

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
        return view('livewire.user-skill-form');
    }
}

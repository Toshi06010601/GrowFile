<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class ExperienceForm extends Component
{
    public ?Experience $experience;

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $company_name = '';

    #[Validate('required|date')]
    public $start_month;

    #[Validate('date|nullable')]
    public $end_month = null;

    #[Validate('string|max:50')]
    public $role = '';

    #[Validate('string')]
    public $description = '';

    /*
    Public functions for the modal form
    */
    #[On('set-experience')]
    public function setExperience($id)
    {
        if($id) {
            $experience          = Experience::findOrFail($id);
            $this->experience    = $experience;
            $this->company_name       = $experience->company_name;
            $this->start_month       = $experience->start_month->format('Y-m-d');
            $this->end_month = $experience->end_month ? $experience->end_month->format('Y-m-d') : null;
            $this->role   = $experience->role;
            $this->description   = $experience->description;
        } else {
            $this->reset();
        }

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-experience');
    }

    public function save()
    {
        //Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();

        //Create new experience
        $this->experience = Experience::create($validatedData);

        //Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');

    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->experience);
        $validateDate = $this->validate();

        //Update the experience
        $this->experience->update($validateDate);

        //Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');
    }

    public function delete()
    {
        //Authorize the data
        $this->authorize('delete', $this->experience);

        //Delete the record
        $this->experience->delete();

        //Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');
    }

    public function render()
    {
        return view('livewire.profile.experience-form');
    }
}

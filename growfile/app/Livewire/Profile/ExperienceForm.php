<?php

namespace App\Livewire\Profile;

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
        // 1. If id is passed, find the experience and assign each field to public variables 
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

        // 2. Reset validation and open experience modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-experience');
    }

    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();

        // 2. Create new experience
        $this->experience = Experience::create($validatedData);

        // 3. Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->experience);

        // 2. Validate inputs
        $validateDate = $this->validate();

        // 3. Update the experience
        $this->experience->update($validateDate);

        // 4. Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->experience);

        // 2. Delete the record
        $this->experience->delete();

        // 3. Reflect the updates in Experiences section
        $this->dispatch('load-experiences')->to(ExperiencesSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-experience');
    }

    public function render()
    {
        return view('livewire.profile.experience-form');
    }
}

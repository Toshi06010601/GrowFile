<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class BioForm extends Component
{
    public ?Profile $profile;

    /*
    Public variables for the modal form
    */
    #[Validate('string')]
    public $bio = '';

    /*
    Public functions for the modal form
    */
    #[On('set-bio')]
    public function setBio($id)
    {
        if($id) {
            $this->reset();
            $profile    = Profile::findOrFail($id);
            $this->profile        = $profile;
            $this->bio            = $profile->bio;
        } else {
            $this->reset();
        }

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-bio');
    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->profile);

        //Validate bio
        $validateData = $this->validate();

        //Update the bio
        $this->profile->update($validateData);

        //Reflect the updates in Bio section
        $this->dispatch('load-bio')->to(BioSection::class);

        //Clean up the modal form, close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-bio');

    }


    public function render()
    {
        return view('livewire.profile.bio-form');
    }
}

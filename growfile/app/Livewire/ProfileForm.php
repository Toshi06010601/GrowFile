<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class ProfileForm extends Component
{
    public ?Profile $profile;

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $fullName = '';

    #[Validate('string|max:255')]
    public $profileImage = '';

    #[Validate('string|max:100')]
    public $headline = '';

    #[Validate('string')]
    public $bio = '';

    #[Validate('string')]
    public $jobStatus = '';

    #[Validate('boolean')]
    public $visibility;

    #[Validate('string|max:100')]
    public $location = '';

    #[Validate('string|max:200')]
    public $githubLink = '';

    #[Validate('string|max:200')]
    public $linkedIn = '';

    /*
    Public functions for the modal form
    */
    #[On('set-profile')]
    public function setProfile($id)
    {
        if($id) {
            $this->profile    = Profile::findOrFail($id);
            $this->full_name       = $profile->full_name;
            $this->profile_image       = $profile->profile_image;
            $this->headline = $profile->headline->format('Y-m-d\TH:i');
            $this->bio   = $profile->bio;
            $this->job_status   = $profile->job_status;
            $this->visibility   = $profile->visibility;
            $this->location   = $profile->location;
            $this->github_link   = $profile->github_link;
            $this->linkedin_link   = $profile->linkedin_link;
        } else {
            $this->reset();
        }

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-profile');
    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->profile);
        $validateDate = $this->validate();

        //Update the profile and register associated tags
        $this->profile->update($validateDate);

        //Reflect the updates in Profile section
        $this->dispatch('load-profile')->to(ProfilesSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-profile');
    }

    public function delete()
    {
        //Authorize the data
        $this->authorize('delete', $this->profile);

        //Delete the record
        $this->profile->delete();

        //Reflect the updates in Profile section
        $this->dispatch('load-profile')->to(ProfilesSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-profile');
    }

    public function render()
    {
        return view('livewire.profile-form');
    }
}

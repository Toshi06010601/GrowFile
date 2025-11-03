<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class ProfileForm extends Component
{
    use WithFileUploads;
    public ?Profile $profile;

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $full_name = '';
 
    #[Validate('image|max:1024')]
    public $profile_image;       // Holds the temporary uploaded file object

    #[Validate('string|max:255')]
    public $profile_image_path = '';   // Holds the URL of the currently saved image

    #[Validate('string|max:100')]
    public $headline = '';

    #[Validate('string')]
    public $bio = '';

    #[Validate('string')]
    public $job_status = '';

    #[Validate('boolean')]
    public $visibility;

    #[Validate('string|max:100')]
    public $location = '';

    #[Validate('string|max:200')]
    public $github_link = '';

    #[Validate('string|max:200')]
    public $linkedin_link = '';

    /*
    Public functions for the modal form
    */
    #[On('set-profile')]
    public function setProfile($id)
    {
        if($id) {
            $this->reset();
            $profile    = Profile::findOrFail($id);
            $this->profile        = $profile;
            $this->full_name      = $profile->full_name;
            $this->profile_image_path = $profile->profile_image_path;
            $this->headline       = $profile->headline;
            $this->bio            = $profile->bio;
            $this->job_status     = $profile->job_status;
            $this->visibility     = $profile->visibility;
            $this->location       = $profile->location;
            $this->github_link    = $profile->github_link;
            $this->linkedin_link  = $profile->linkedin_link;
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
        $validateData = $this->validate();

        // $fileName = 'profile_image_' . Auth::id() . '.' . $this->profile_image->getClientOriginalExtension();
        // $this->profile_image->storeAs(path: 'profile_photos', name: $fileName);
        // $this->profile_image_path = "storage/profile_photos/" . $fileName;
        // unset($validateData['profile_image']);

        //Update the profile and register associated tags
        $this->profile->update($validateData);

        //Reflect the updates in Profile section
        $this->dispatch('load-profile')->to(ProfileSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-profile');
    }

    public function render()
    {
        return view('livewire.profile-form');
    }
}

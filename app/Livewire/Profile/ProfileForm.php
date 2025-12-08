<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ProfileForm extends Component
{
    use WithFileUploads;
    public ?Profile $profile;

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $full_name = '';

    public $profile_image;       // Holds the temporary uploaded file object

    #[Validate('string|max:255')]
    public $profile_image_path = '';   // Holds the URL of the currently saved image

    #[Validate('string|max:100')]
    public $headline = '';

    #[Validate('in:open_to_work,not_looking,freelance,exploring')]
    public $job_status = '';

    #[Validate('boolean')]
    public $visibility;

    #[Validate('string|max:100')]
    public $location = '';

    #[Validate('nullable|url|string|max:200')]
    public $github_link = '';

    #[Validate('nullable|url|string|max:200')]
    public $linkedin_link = '';



    /*
    Public functions for the modal form
    */
    #[On('set-profile')]
    public function setProfile($id)
    {
        // 1. If id is passed, find the profile and get all the values
        if($id) {
            $this->reset();
            $profile    = Profile::findOrFail($id);
            $this->profile        = $profile;
            $this->full_name      = $profile->full_name;
            $this->profile_image_path = $profile->profile_image_path;
            $this->headline       = $profile->headline;
            $this->job_status     = $profile->job_status;
            $this->visibility     = $profile->visibility;
            $this->location       = $profile->location;
            $this->github_link    = $profile->github_link;
            $this->linkedin_link  = $profile->linkedin_link;
        } else {
            $this->reset();
        }

        // 2. Reset validation
        $this->resetValidation();

        // 3. Dispatch profile editor modal
        $this->dispatch('open-modal', 'edit-profile');
    }

    public function update()
    {
        // 1. Authorize and validate the data
        $this->authorize('update', $this->profile);

        // 2. Update profile_image_path if new profile image uploaded
        if ($this->profile_image) {
            // 2.1 Store the old profile name
            $oldFileName =  str_replace('storage/', '', $this->profile_image_path);

            // 2.2 Validate new image
            $this->validate(['profile_image' => 'image|max:1024']);

            // 2.3 Construct new file name and assign it to profile img path
            $newFileName = (string) Str::uuid() . '.' .  $this->profile_image->getClientOriginalExtension();
            $this->profile_image_path = "/storage/profile_photos/" . $newFileName;

            // 2.4 Save profile_image to the folder 
            $this->profile_image->storeAs(path: 'profile_photos', name: $newFileName);
            
            // 2.5 Delete old image file except for default image
            if($oldFileName !== "/profile_photos/default.svg") {
                    Storage::disk('public')->delete($oldFileName);
            }
        }

        // 3. Validate all data
        $validateData = $this->validate();

        // 4. Update the profile
        $this->profile->update($validateData);

        // 5. Refresh Profile section with new profile image
        $this->dispatch('load-profile')->to(ProfileSection::class);

        // 6. Refresh navigation bar with new profile image
        $this->dispatch('set-profile-menu-icon', ['filePath' => $this->profile_image_path]);

        // 7. Clean up the modal form, close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-profile');

    }

    public function render()
    {
        return view('livewire.profile.profile-form');
    }
}

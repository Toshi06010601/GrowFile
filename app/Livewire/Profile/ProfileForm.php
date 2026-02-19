<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use App\Traits\HasImageUpload;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProfileForm extends Form
{
    use HasImageUpload;

    public ?Profile $profile = null;

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $full_name = '';

    #[Validate('nullable|mimes:jpg,jpeg,png,webp|max:1024')]
    public $profile_image;       // Holds the temporary uploaded file object

    #[Validate('required|string|max:255')]
    public $profile_image_path = '';   // Holds the URL of the currently saved image

    #[Validate('required|string|max:100')]
    public $headline = '';

    #[Validate('required|in:open_to_work,not_looking,freelance,exploring')]
    public $job_status = '';

    #[Validate('required|boolean')]
    public $visibility;

    #[Validate('required|string|max:100')]
    public $location = '';

    #[Validate('nullable|url|string|max:500')]
    public $github_link = '';

    #[Validate('nullable|url|string|max:500')]
    public $linkedin_link = '';

    /*
    Public functions for the modal form
    */
    public function setFields(Profile $profile)
    {
        $this->resetValidation();

        $this->profile = $profile;
 
        $this->fill([
                ...$profile->only('full_name', 'profile_image_path', 'headline', 'job_status', 'visibility', 'location', 'github_link', 'linkedin_link')
            ]);
    }


    public function update()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);
            
            // 2. Upload Image
            $this->uploadProfileImage();

            // 3. Update profile
            $this->profile->update(
               $this->only('full_name', 'profile_image_path', 'headline', 'job_status', 'visibility', 'location', 'github_link', 'linkedin_link')
            );
     
        });
    }

    /*
    Protected functions for the modal form
    */
    protected function uploadProfileImage()
    {
        if (!$this->profile_image) {
            return;
        }

        $oldPath = $this->profile_image_path;

        // 1. Upload new image and store file path
        $this->profile_image_path = $this->uploadNewImage(
            $this->profile_image,
            'profile_photos',
            $oldPath
        );

        // 2. Delete old image if successfull
        DB::aftercommit(fn() => $this->deleteOldImage( $oldPath, '/default.jpg' ));
    }

}

<?php

namespace App\Livewire\Profile\Background;

use App\Models\Profile;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use App\Traits\HasImageUpload;
use Illuminate\Support\Facades\Auth;
use Exception;

class BackgroundForm extends Form
{
    use HasImageUpload;

    public ?Profile $profile = null;

    #[Validate('nullable|mimes:jpg,jpeg,png,webp|max:1024')]
    public $background_image = null;       // Holds the temporary uploaded file object
    
    #[Validate('nullable|string')]
    public $background_image_path = '';  

    /*
    Public functions for the modal form
    */
    public function setFields(Profile $profile)
    {
        $this->resetValidation();

        $this->profile = $profile;
 
        $this->fill([
                ...$profile->only('background_image_path'),
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
            $this->uploadBackgroundImage();

            // 3. Update profile
            $this->profile->update(
               $this->only('background_image_path')
            );
     
        });
    }

    /*
    Protected functions for the modal form
    */
    protected function uploadBackgroundImage()
    {
        if (!$this->background_image) {
            return;
        }

        $oldPath = $this->background_image_path;

        // 1. Upload new image and store file path
        $this->background_image_path = $this->uploadNewImage(
            $this->background_image,
            'background_photos',
            $oldPath
        );

        // 2. Delete old image if successfull
        DB::aftercommit(fn() => $this->deleteOldImage( $oldPath, '/default.jpg' ));
    }

}

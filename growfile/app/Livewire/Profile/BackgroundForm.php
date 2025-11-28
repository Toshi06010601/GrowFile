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

class BackgroundForm extends Component
{
    use WithFileUploads;
    public ?Profile $profile;

    /*
    Public variables for the modal form
    */
    public $background_image;       // Holds the temporary uploaded file object

    #[Validate('string|max:255')]
    public $background_image_path = '';   // Holds the URL of the currently saved image

    /*
    Public functions for the modal form
    */
    #[On('set-background')]
    public function setBackground($id)
    {
        if($id) {
            $this->reset();
            $profile    = Profile::findOrFail($id);
            $this->profile        = $profile;
            $this->background_image_path = $profile->background_image_path ? $profile->background_image_path : 'storage/background_photos/default.png';
        } else {
            $this->reset();
        }

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-background');
    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->profile);

        //Update background_image_path if new background image uploaded
        if ($this->background_image) {
            //Store the old background name
            $oldFileName =  str_replace('storage/', '', $this->background_image_path);

            //Validate new image and Update background_image_path
            $this->validate(['background_image' => 'image|max:1024']);
            $newFileName = (string) Str::uuid() . '.' .  $this->background_image->getClientOriginalExtension();
            $this->background_image_path = "storage/background_photos/" . $newFileName;

            //Save background_image to the folder and delete the old image
            $this->background_image->storeAs(path: 'background_photos', name: $newFileName);
            if($oldFileName !== "background_photos/default.png") {
                Storage::disk('public')->delete($oldFileName);
            }
        }

        //Validate all data and remove background_image from $validatedData
        $validateData = $this->validate();

        //Update the background
        $this->profile->update($validateData);

        //Reflect the updates in Background section
        $this->dispatch('load-background')->to(BackgroundSection::class);

        //Clean up the modal form, close the modal and delete the old background image
        $this->reset();
        $this->dispatch('close-modal', 'edit-background');

    }

    public function render()
    {
        return view('livewire.profile.background-form');
    }
}

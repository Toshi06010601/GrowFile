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
        // 1. If id is passed, find the profile and get background image path
        if($id) {
            $this->reset(); // Reset to refresh the temporary image
            $profile    = Profile::findOrFail($id);
            $this->profile        = $profile;
            $this->background_image_path = $profile->background_image_path;
        } else {
            $this->reset();
        }

        // 2. Reset validation
        $this->resetValidation();

        // 3. Dispatch background editor modal
        $this->dispatch('open-modal', 'edit-background');
    }

    public function update()
    {
        // 1. Authorize and validate the data
        $this->authorize('update', $this->profile);

        // 2. Update background_image_path if new background image uploaded
        if ($this->background_image) {
            // 2.1. Store the old background name
            $oldFileName =  str_replace('storage/', '', $this->background_image_path);

            // 2.2. Validate newly uploaded image
            $this->validate(['background_image' => 'image|max:1024']);

            // 2.3. Construct new file name and assign it to background image path
            $newFileName = (string) Str::uuid() . '.' .  $this->background_image->getClientOriginalExtension();
            $this->background_image_path = "/storage/background_photos/" . $newFileName;

            // 2.4. Save background_image to the folder
            $this->background_image->storeAs(path: 'background_photos', name: $newFileName);

            // 2.5. Delete old image file except for the default image
            if($oldFileName !== "/background_photos/default.jpg") {
                Storage::disk('public')->delete($oldFileName);
            }
        }

        // 3. Validate all data 
        $validateData = $this->validate();

        // 4. Update the profile with the new background image
        $this->profile->update($validateData);

        // 5. Refresh Background section with new background image
        $this->dispatch('load-background')->to(BackgroundSection::class);

        // 6. Clean up the modal form, close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-background');

    }

    public function render()
    {
        return view('livewire.profile.background-form');
    }
}

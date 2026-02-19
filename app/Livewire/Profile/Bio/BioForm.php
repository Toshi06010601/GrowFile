<?php

namespace App\Livewire\Profile\Bio;

use App\Models\Profile;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class BioForm extends Form
{
    public ?Profile $profile = null;

    /*
    Public variables for the modal form
    */
    #[Validate('nullable|string')]
    public $bio = '';

    /*
    Public functions for the modal form
    */
    public function setFields(Profile $profile)
    {
        $this->resetValidation();

        // throw new Exception("Error Processing Request", 1);
        

        $this->profile = $profile;
 
        $this->fill([
                ...$profile->only('bio'),
            ]);
    }


    public function update()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);

            // 3. Update profile
            $this->profile->update(
               $this->only('bio')
            );
     
        });
    }

}


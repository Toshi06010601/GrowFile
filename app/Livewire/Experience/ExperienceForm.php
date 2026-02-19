<?php

namespace App\Livewire\Experience;

use App\Models\Experience;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class ExperienceForm extends Form
{
    public ?Experience $experience = null;

    #[Validate('required|string|max:100')]
    public $company_name = '';

    #[Validate('required|date')]
    public $start_month;

    #[Validate('nullable|date')]
    public $end_month = null;

    #[Validate('required|string|max:50')]
    public $role = '';

    #[Validate('nullable|string')]
    public $description = '';

    /*
    Public functions for the modal form
    */
    public function setFields(Experience $experience)
    {
        $this->resetValidation();

        $this->experience = $experience;
 
        $this->fill([
            ...$experience->only('company_name', 'role', 'description'),
            'start_month' => $experience->start_month ? $experience->start_month->format('Y-m-d') : null,
            'end_month' => $experience->end_month ? $experience->end_month->format('Y-m-d') : null,
        ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);

            $this->end_month = $this->end_month ?: null; 

            // 2. Create new experience
            Experience::create(
                $this->only('company_name', 'role', 'description', 'start_month', 'end_month')
                + 
                ['user_id' => Auth::id()]
            );
     
        });
    }

    public function update()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);

            $data = $this->only('company_name', 'role', 'description', 'start_month', 'end_month');

            $data['end_month'] = $data['end_month'] ?: null; 

            // 2. Update experience
            $this->experience->update($data);
     
        });
    }

}


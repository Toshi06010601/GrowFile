<?php

namespace App\Livewire\Course;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Livewire\Form;
use Exception;

class CourseForm extends Form
{
    public ?Course $course = null;

    #[Validate('required|string|max:100')]
    public $provider = '';

    #[Validate('required|string|max:100')]
    public $name = '';

    #[Validate('nullable|string')]
    public $description = '';
    
    #[Validate('nullable|string|url|max:500')]
    public $course_url = '';

   #[Validate('in:in_progress,completed')]
    public $progress_status = 'in_progress';
    
    #[Validate('nullable|string|url|max:500')]
    public $certificate_url = '';

    #[Validate('date|nullable')]
    public $completion_date = null;

    /*
    Public functions for the modal form
    */
    public function setFields(Course $course)
    {
        $this->course = $course;
 
        $this->fill([
                ...$course->only('name', 'description', 'provider', 'progress_status', 'course_url', 'certificate_url'),
                'completion_date' => $course->completion_date ? $course->completion_date->format('Y-m-d') : null,
            ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);
            
            $this->completion_date ?: $this->completion_date = null;

            // 3. Create new course
            Course::create(
                $this->only('name', 'description', 'provider', 'progress_status', 'course_url', 'certificate_url', 'completion_date')
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

            $this->completion_date ?: $this->completion_date = null;
            

            // 3. Update course
            $this->course->update(
                $this->only('name', 'description', 'provider', 'progress_status', 'course_url', 'certificate_url', 'completion_date')
            );
     
        });
    }

}

<?php

namespace App\Livewire\Profile;

use App\Livewire\Profile\CourseSection;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CourseForm extends Component
{
    public ?Course $course;
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string')]
    public $provider;

    #[Validate('required|string|max:100')]
    public $name;

    #[Validate('required|string|max:255')]
    public $description;
    
    #[Validate('string')]
    public $course_url;

   #[Validate('in:in_progress,completed')]
    public $progress_status = 'in_progress';
    
    #[Validate('string')]
    public $certificate_url;

    #[Validate('required|date')]
    public $completion_date;

    /*
    Public functions for the modal form
    */
    #[On('set-course')]
    public function setCourse($id, $isOwner)
    {
        // 1. If id is passed, find the course and assign each field to public variables 
        if($id) {
            $course          = Course::findOrFail($id);
            $this->course    = $course;
            $this->name         = $course->name;
            $this->description        = $course->description;
            $this->provider   = $course->provider;
            $this->progress_status    = $course->progress_status;
            $this->completion_date = $course->completion_date ? $course->completion_date->format('Y-m-d') : null;
            $this->course_url = $course->course_url;
            $this->certificate_url = $course->certificate_url;
        } else {
            $this->reset();
        }

        // 2. Assign isOwner value
        $this->isOwner = $isOwner;

        // 3. Reset validation and open Course modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-course');
    }


    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        // 2. Create new course
        Course::create($validatedData);

        // 3. Reflect the updates in course section
        $this->dispatch('load-courses')->to(CourseSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-course');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->course);

        // 2. validate the data
        $validatedData = $this->validate();

        // 3. Update the course
        $this->course->update($validatedData);

        // 4. Reflect the updates in Course section
        $this->dispatch('load-courses')->to(CourseSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-course');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->course);

        // 2. Delete the record
        $this->course->delete();

        // 3. Reflect the updates in Course section
        $this->dispatch('load-courses')->to(CourseSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-course');
    }

    public function render()
    {
        return view('livewire.profile.course-form');
    }
}

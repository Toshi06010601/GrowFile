<?php

namespace App\Livewire\Course;

use App\Livewire\Course\CourseSection;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Course\CourseForm;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CourseEditor extends Component
{
    public CourseForm $form;

    #[Locked]
    public $isOwner = false;
 
    /*
    Public functions for the modal form
    */
    #[On('set-course')]
    public function setCourse($id)
    {
         try {
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                // throw new Exception("Error Processing Request", 1);
                $course = Course::findOrFail($id);
                $this->isOwner = Auth::id() === $course->user_id;
                $this->form->setFields($course);
            } else {
                // throw new Exception('Testing error handling');
                $this->isOwner = Auth::check();
            }
    
            $this->dispatch('open-modal', 'edit-course');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "Course not found.");
            logger()->warning('Course not found', ['course_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load course modal.");
            logger()->error('Failed to load course modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
      
    }


    public function save()
    {
        $isUpdate = (bool) $this->form->course;
        
        try {
            // throw new Exception("Error Processing Request", 1);
            
            $isUpdate && $this->authorize('update', $this->form->course);
            $isUpdate ? $this->form->update() : $this->form->store();
            $this->finishAction($isUpdate ? 'updated' : 'created');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError($isUpdate ? 'update' : 'create', $e);
        }

    }

  public function delete()
    {
        try {
            $this->authorize('delete', $this->form->course);
            // throw new Exception('Testing error handling');
            $this->form->course->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }

    public function render()
    {
        return view('livewire.course.editor');
    }

    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('courses-updated')->to(component: CourseSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-course');
        $this->dispatch('flash-message', type: 'success', message: "Course {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} course. Please try again.");
        logger()->error("Course {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

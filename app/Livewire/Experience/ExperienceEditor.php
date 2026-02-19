<?php

namespace App\Livewire\Experience;

use Livewire\Component;
use App\Livewire\Experience\ExperienceSection;
use App\Models\Experience;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Experience\ExperienceForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ExperienceEditor extends Component
{
    public ExperienceForm $form;

    #[Locked]
    public $isOwner = false;

    /*
    Public functions for the modal form
    */
    #[On('set-experience')]
    public function setPortfolio($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                // throw new Exception('Testing error handling');
                $experience = Experience::findOrFail($id);
                $this->isOwner = Auth::id() === $experience->user_id;
                $this->form->setFields($experience);
            } else {
                $this->isOwner = Auth::check();
            }
    
            $this->dispatch('open-modal', 'edit-experience');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "The selected experience not found.");
            logger()->warning('Experience not found', ['article_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load experience form.");
            logger()->error('Failed to load experience form', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->experience;
        
        try {
            $isUpdate && $this->authorize('update', $this->form->experience);
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
            $this->authorize('delete', $this->form->experience);
            // throw new Exception('Testing error handling');
            $this->form->experience->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }
    
    public function render()
    {
        return view('livewire.experience.editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('experiences-updated')->to(component: ExperienceSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-experience');
        $this->dispatch('flash-message', type: 'success', message: "Experience {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} experience. Please try again.");
        logger()->error("Experience {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

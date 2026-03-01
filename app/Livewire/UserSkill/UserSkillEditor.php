<?php

namespace App\Livewire\UserSkill;

use Livewire\Component;
use App\Models\UserSkill;
use App\Livewire\UserSkill\UserSkillsSection;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\UserSkill\UserSkillForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UserSkillEditor extends Component
{
    public UserSkillForm $form;

    /*
    Public functions for the modal form
    */
    #[On('set-user-skill')]
    public function setUserSkill($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                // Not using findOrFail method here as it will use with method to retrieve skill
                $this->form->setFields($id);
            } else {
                
            }
            
            // Trigger category initialize method with the current skillId 
            $this->dispatch('trigger-category-init', [
                'skillId' => $this->form->skill_id
            ]);
            $this->dispatch('open-modal', 'edit-user-skill');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.user-skill.not-found'));
            logger()->warning('User skill not found', ['user_skill_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.user-skill.failed-load'));
            logger()->error('Failed to load user skill modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->userSkill;
        
        try {
            $isUpdate ? $this->authorize('update', $this->form->userSkill) : Auth::check();
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
            $this->authorize('delete', $this->form->userSkill);
            $this->form->userSkill->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }

    public function render()
    {
        return view('livewire.user-skill.editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('user-skills-updated')->to(component: UserSkillSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-user-skill');
        $this->dispatch('flash-message', type: 'success', message: __("flash.user-skill.{$actionName}"));
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: __("flash.user-skill.failed-{$actionName}"));
        logger()->error("User skill {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

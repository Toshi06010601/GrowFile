<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\BioSection;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\BioForm;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BioEditor extends Component
{
    /*
    Public functions for the modal form
    */
    public BioForm $form;

    #[Locked]
    public $isOwner = false;

    /*
    Public functions for the modal form
    */
    #[On('set-bio')]
    public function setBio($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
            
            $profile = Profile::findOrFail($id);
            $this->isOwner = Auth::id() === $profile->user_id;
            $this->form->setFields($profile);

            $this->dispatch('open-modal', 'edit-bio');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "Profile not found.");
            logger()->warning('Profile not found', ['profile_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load bio modal.");
            logger()->error('Failed to load bio modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        try {
            $this->authorize('update', $this->form->profile);
            $this->form->update();
            $this->finishAction('updated');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError('update', $e);
        }
    }

    public function render()
    {
        return view('livewire.profile.bio-editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('bio-updated')->to(component: BioSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-bio');
        $this->dispatch('flash-message', type: 'success', message: "Bio {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} bio. Please try again.");
        logger()->error("Bio {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

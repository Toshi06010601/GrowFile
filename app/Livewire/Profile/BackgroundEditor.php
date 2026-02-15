<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\BackgroundSection;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\BackgroundForm;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BackgroundEditor extends Component
{
    use WithFileUploads;

    public BackgroundForm $form;

    /*
    Public functions for the modal form
    */
    #[On('set-background')]
    public function setBackground($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
            
            $profile = Profile::findOrFail($id);
            $this->form->setFields($profile);

            $this->dispatch('open-modal', 'edit-background');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "Profile not found.");
            logger()->warning('Profile not found', ['profile_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load background image modal.");
            logger()->error('Failed to load profile modal', ['id' => $id, 'error' => $e->getMessage()]);
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
        return view('livewire.profile.background-editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('background-updated')->to(component: BackgroundSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-background');
        $this->dispatch('flash-message', type: 'success', message: "Background {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} background image. Please try again.");
        logger()->error("Background {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

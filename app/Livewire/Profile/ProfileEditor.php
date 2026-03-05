<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\ProfileSection;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Profile\ProfileForm;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProfileEditor extends Component
{
    use WithFileUploads;

    public ProfileForm $form;

    /*
    Public functions for the modal form
    */
    #[On('set-profile')]
    public function setProfile($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
            
            $profile = Profile::findOrFail($id);
            $this->form->setFields($profile);
            $this->dispatch('open-modal', 'edit-profile');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.profile.not-found'));
            logger()->warning('Profile not found');
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.profile.failed-load'));
            logger()->error('Failed to load profile modal', ['error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        try {
            $this->authorize('update', $this->form->profile);
            $this->form->update();
            $this->dispatch('set-profile-menu-icon', filePath: $this->form->profile_image_path);
            $this->finishAction('updated');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError('update', $e);
        }
    }

    public function render()
    {
        return view('livewire.profile.editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('profile-updated')->to(component: ProfileSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-profile');
        $this->dispatch('flash-message', type: 'success', message: __("flash.profile.{$actionName}"));
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: __("flash.profile.failed-{$actionName}"));
        logger()->error("Profile {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

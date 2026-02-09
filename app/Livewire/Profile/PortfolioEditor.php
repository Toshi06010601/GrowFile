<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\PortfolioSection;
use App\Models\Portfolio;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\PortfolioForm;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PortfolioEditor extends Component
{
    use WithFileUploads;

    public PortfolioForm $form;

    #[Locked]
    public $isOwner = false;

    /*
    Public functions for the modal form
    */
    #[On('set-portfolio')]
    public function setPortfolio($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                // throw new Exception('Testing error handling');
                $portfolio = Portfolio::findOrFail($id);
                $this->isOwner = Auth::id() === $portfolio->user_id;
                $this->form->setFields($portfolio);
            } else {
                $this->isOwner = Auth::check();
            }
    
            $this->dispatch('open-modal', 'edit-portfolio');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('portfolios-updated')->to(PortfolioSection::class);
            $this->dispatch('flash-message', type: 'error', message: "portfolio not found.");
            logger()->warning('portfolio not found', ['article_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('portfolios-updated')->to(PortfolioSection::class);
            $this->dispatch('flash-message', type: 'error', message: "Failed to load portfolio modal.");
            logger()->error('Failed to load portfolio modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->portfolio;
        
        try {
            $isUpdate && $this->authorize('update', $this->form->portfolio);
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
            $this->authorize('delete', $this->form->portfolio);
            throw new Exception('Testing error handling');
            $this->form->portfolio->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }
    
    public function render()
    {
        return view('livewire.profile.portfolio-editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('portfolios-updated')->to(PortfolioSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-portfolio');
        $this->dispatch('flash-message', type: 'success', message: "portfolio {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} portfolio. Please try again.");
        logger()->error("portfolio {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

}

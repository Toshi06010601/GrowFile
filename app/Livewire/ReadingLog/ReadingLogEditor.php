<?php

namespace App\Livewire\ReadingLog;
use App\Livewire\ReadingLog\ReadingLogSection;
use App\Models\ReadingLog;
use App\Services\GoogleBooksService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use App\Livewire\ReadingLog\ReadingLogForm;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ReadingLogEditor extends Component
{
    public $suggestions = [];
    public $search = '';
    public ReadingLogForm $form;

    #[Locked]
    public $isOwner = false;

    /*
      Functions for Reading log form
    */

    #[On('set-reading-log')]
    public function setReadingLog($id)
    {
        try {
            $this->reset('suggestions', 'search');
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                $readingLog = ReadingLog::findOrFail($id);
                $this->isOwner = Auth::id() === $readingLog->user_id;
                $this->form->setFields($readingLog);
            } else {
                // throw new Exception('Testing error handling');
                $this->isOwner = Auth::check();
            }
    
            // dd('test');
            $this->dispatch('open-modal', 'edit-reading-log');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "Reading log not found.");
            logger()->warning('Reading log not found', ['article_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load reading log modal.");
            logger()->error('Failed to load reading log modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->readingLog;
        
        try {
            $isUpdate && $this->authorize('update', $this->form->readingLog);
            $isUpdate ? $this->form->update() : $this->form->store();
            $this->finishAction($isUpdate ? 'updated' : 'created');
            $isUpdate ?: $this->dispatch('scroll-to-start');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError($isUpdate ? 'update' : 'create', $e);
        }
    }
    
    public function delete()
    {
        try {
            $this->authorize('delete', $this->form->readingLog);
            // throw new Exception('Testing error handling');
            $this->form->readingLog->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }

    public function render()
    {
        return view('livewire.reading-log.editor');
    }
    

    /*
     Functions for Google Books API 
    */

    // Search books using google books api
    public function updatedSearch (GoogleBooksService $service) {

        if($this->search === "") return;
        
        try {
            $this->suggestions = $service->search($this->search);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to search books. Please try again.");
        }

    }

    // Select book by getting info from google books api
    public function selectBook($id) {
        
        try {
            $service = app(GoogleBooksService::class);
            $bookInfo = $service->selectBook($id);
            $this->form->fill(
                collect($bookInfo)->only('title', 'author', 'total_pages', 'cover_url')
            );
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to select book. Please try again.");
        }
        
    }

    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('reading-logs-updated')->to(component: ReadingLogSection::class);
        $this->form->reset();
        $this->reset('search', 'suggestions');
        $this->dispatch('close-modal', 'edit-reading-log');
        $this->dispatch('flash-message', type: 'success', message: "Reading log {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} reading log. Please try again.");
        logger()->error("Reading log {$actionName} action failed.", ['error' => $e->getMessage()]);
    }
}

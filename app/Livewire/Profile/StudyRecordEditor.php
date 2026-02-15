<?php
namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\StudyRecordsSection;
use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\StudyRecordForm;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class StudyRecordEditor extends Component
{
    public StudyRecordForm $form;

    #[Locked]
    public $isOwner = false;

    /*
    Public functions for the modal form
    */
    #[On('set-study-record')]
    public function setStudyRecord($id)
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();
    
            if($id) {
                $studyRecord = StudyRecord::findOrFail($id);
                $this->isOwner = Auth::id() === $studyRecord->user_id;
                // throw new Exception('Testing error handling');
                $this->form->setFields($studyRecord);
            } else {
                $this->isOwner = Auth::check();
            }
    
            $this->dispatch('open-modal', 'edit-study-record');
            
        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: "Study record not found.");
            logger()->warning('Study record not found', ['article_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: "Failed to load study record modal.");
            logger()->error('Failed to load study record modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->studyRecord;
        
        try {
            $isUpdate && $this->authorize('update', $this->form->studyRecord);
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
            $this->authorize('delete', $this->form->studyRecord);
            throw new Exception('Testing error handling');
            $this->form->studyRecord->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }

    public function render()
    {
        return view('livewire.profile.study-record-editor');
    }
    
    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('study-records-updated')->to(component: StudyRecordEditor::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-study-record');
        $this->dispatch('flash-message', type: 'success', message: "Study record {$actionName} successfully.");
    }

    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: "Failed to {$actionName} study record. Please try again.");
        logger()->error("Study record {$actionName} action failed.", ['error' => $e->getMessage()]);
    }
    

}

<?php
namespace App\Livewire\Profile;

use App\Livewire\Profile\StudyRecordsSection;
use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Exception;


class StudyRecordForm extends Component
{
    public ?StudyRecord $studyRecord = null;
    public $selectedTags = [];

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $category = '';

    #[Validate('string')]
    public $activity = '';

    #[Validate('required|date')]
    public $start_datetime = null;

    #[Validate('required|date|after:start_datetime')]
    public $end_datetime = null;

    /*
    Public functions for the modal form
    */
    #[On('set-study-record')]
    public function setStudyRecord($id)
    {
        // 1. If id is passed, find the studyrecord and assign each field to public variables 
        if($id) {
           $studyRecord = StudyRecord::findOrFail($id);
            $this->studyRecord = $studyRecord;
            $this->fill([
                ...$studyRecord->only('category', 'activity'),
                'start_datetime' => $studyRecord->start_datetime->format('Y-m-d\TH:i'),
                'end_datetime' => $studyRecord->end_datetime->format('Y-m-d\TH:i'),
                'selectedTags' => $studyRecord->tags()->pluck('tags.id')->toArray()
            ]);
        } else {
            $this->reset();
        }

        // 2. Reset validation and open studyrecord modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-study-record');
    }

    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();
        
        // 2. Create new studyrecord and register associated tags
        try {
            // 2.1. Attempt to save both studyrecord and tags
            DB::transaction(function () use ($validatedData) {
                $this->studyRecord = StudyRecord::create($validatedData);
                $this->studyRecord->tags()->sync($this->selectedTags);
                throw new Exception('Testing error handling');
            });

            // 2.2. Reflect the updates in Study records section with flash message
            $this->dispatch('load-study-records', type: 'success', message: 'Study record created successfully.')->to(StudyRecordsSection::class);

        } catch(Exception $e) {
            reset('studyRecord');
            // 2.1. Display session flash message and log error 
            session()->flash('error', 'Failed to save study record. Please try again.');
            logger()->error('Study record save action failed.', ['error details' => $e->getMessage()]);
            return;
        }


        // 3. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');

    }

   public function update()
    {
         // 1. Authorize the data
        $this->authorize('update', $this->studyRecord);
        
        // 2. Validate and prepare the data
        $validatedData = $this->validate();

        // 3. Update new studyrecord and register associated tags
        try {
            // 3.1. Attempt to update both studyrecord and tags
            DB::transaction(function () use ($validatedData) {
                $this->studyRecord->update($validatedData);
                $this->studyRecord->tags()->sync($this->selectedTags);
                throw new Exception('Testing error handling');
            });

            // 3.2. Reflect the updates in Study records section with flash message
            $this->dispatch('load-study-records', type: 'success', message: 'Study record updated successfully.')->to(StudyRecordsSection::class);

        } catch(Exception $e) {
            // 3.1. Display session flash message and log error 
            session()->flash('error', 'Failed to update study record. Please try again.');
            logger()->error('Study record update failed', ['error details' => $e->getMessage()]);
            return;
        }

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->studyRecord);

        // 2. Delete studyrecord and associated tags
        try {
            // 2.1. Delete the record
            throw new Exception('Testing error handling');
            $this->studyRecord->delete();
            
            // 2.2. Reflect the updates in Study records section
            $this->dispatch('load-study-records', type: 'success', message: 'Study record deleted successfully.')->to(StudyRecordsSection::class);
        } catch(Exception $e) {
            // 2.1. Display session flash message and log error 
            session()->flash('error', 'Failed to delete study record. Please try again.');
            logger()->error('Study record delete failed', ['error' => $e->getMessage()]);
            return;
        }

        // 3. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function render()
    {
        return view('livewire.profile.study-record-form');
    }
}
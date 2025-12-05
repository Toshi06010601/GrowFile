<?php
namespace App\Livewire\Profile;

use App\Livewire\Profile\StudyRecordsSection;
use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StudyRecordForm extends Component
{
    public ?StudyRecord $studyRecord;
    public $studyRecordId;
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

    #[Validate('required|date')]
    public $end_datetime = null;

    /*
    Public functions for the modal form
    */
    #[On('set-study-record')]
    public function setStudyRecord($id)
    {
        // 1. If id is passed, find the studyrecord and assign each field to public variables 
        if($id) {
            $studyRecord          = StudyRecord::findOrFail($id);
            $this->studyRecord    = $studyRecord;
            $this->category       = $studyRecord->category;
            $this->activity       = $studyRecord->activity;
            $this->start_datetime = $studyRecord->start_datetime->format('Y-m-d\TH:i');
            $this->end_datetime   = $studyRecord->end_datetime->format('Y-m-d\TH:i');
            $this->selectedTags = $studyRecord->tags()->orderBy('created_at')->get()->pluck('id')->toArray();
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
        $this->studyRecord = StudyRecord::create($validatedData);
        $this->studyRecord->tags()->sync($this->selectedTags);

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->studyRecord);

        // 2. validate the data
        $validateDate = $this->validate();

        // 3. Update the studyrecord and register associated tags
        $this->studyRecord->update($validateDate);
        $this->studyRecord->tags()->sync($this->selectedTags);

        // 4. Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->studyRecord);

        // 2. Delete the record
        $this->studyRecord->delete();

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function render()
    {
        return view('livewire.profile.study-record-form');
    }
}
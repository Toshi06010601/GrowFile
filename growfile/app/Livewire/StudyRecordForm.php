<?php
namespace App\Livewire;

use App\Livewire\StudyRecordsSection;
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

        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-study-record');
    }

    public function save()
    {
        //Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();

        //Create new studyrecord and register associated tags
        $this->studyRecord = StudyRecord::create($validatedData);
        $this->studyRecord->tags()->sync($this->selectedTags);

        //Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');

    }

    public function update()
    {
        //Authorize and validate the data
        $this->authorize('update', $this->studyRecord);
        $validateDate = $this->validate();

        //Update the studyrecord and register associated tags
        $this->studyRecord->update($validateDate);
        $this->studyRecord->tags()->sync($this->selectedTags);

        //Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        //Authorize the data
        $this->authorize('delete', $this->studyRecord);

        //Delete the record
        $this->studyRecord->delete();

        //Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        //Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function render()
    {
        return view('livewire.study-record-form');
    }
}
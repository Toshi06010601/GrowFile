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
    public $selectedTag = [];

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
    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        StudyRecord::create($validatedData);

        $this->reset();

        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        $this->dispatch('close-modal', 'edit-study-record');

    }

    #[On('set-study-record')]
    public function setStudyRecord($id)
    {
        $studyRecord          = StudyRecord::findOrFail($id);
        $this->studyRecord    = $studyRecord;
        $this->category       = $studyRecord->category;
        $this->activity       = $studyRecord->activity;
        $this->start_datetime = $studyRecord->start_datetime->format('Y-m-d\TH:i');
        $this->end_datetime   = $studyRecord->end_datetime->format('Y-m-d\TH:i');
        $this->selectedTags   = $studyRecord->tags()->orderBy('created_at')->get();

        $this->dispatch('open-modal', 'edit-study-record');
    }

    public function update()
    {
        $this->authorize('update', $this->studyRecord);

        $validateDate = $this->validate();

        $this->studyRecord->update($validateDate);

        $this->reset();

        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        $this->authorize('delete', $this->studyRecord);

        $this->studyRecord->delete();

        $this->reset();

        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        $this->dispatch('close-modal', 'edit-study-record');
    }
}

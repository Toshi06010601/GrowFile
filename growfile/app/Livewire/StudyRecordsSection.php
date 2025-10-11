<?php
namespace App\Livewire;

use App\Models\StudyRecord;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StudyRecordsSection extends Component
{
    /*
    Public variables and functions for the section area
    */
    public $userId = '';
    public $records = [];
    public ?StudyRecord $studyRecord;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadResult();
    }

    public function loadResult()
    {
        $this->records = StudyRecord::where('user_id', $this->userId)
            ->orderByDesc('start_datetime')
            ->get();
    }

    /*
    Public variables and functions for the modal form
    */
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('string')]
    public $description = '';

    #[Validate('required|date')]
    public $start_datetime = null;

    #[Validate('required|date')]
    public $end_datetime = null;

    public function setStudyRecord(StudyRecord $studyRecord)
    {
        $this->studyRecord    = $studyRecord;
        $this->title          = $studyRecord->title;
        $this->description    = $studyRecord->description;
        $this->start_datetime = $studyRecord->start_datetime->format('Y-m-d\TH:i');
        $this->end_datetime   = $studyRecord->end_datetime->format('Y-m-d\TH:i');

        $this->dispatch('open-modal', 'edit-study-record');
    }

    public function update()
    {
        $this->authorize('update', $this->studyRecord);

        $validateDate = $this->validate();

        $this->studyRecord->update($validateDate);

        $this->reset(['studyRecord', 'title', 'description', 'start_datetime', 'end_datetime']);

        $this->loadResult();

        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        $this->authorize('delete', $this->studyRecord);

        $this->studyRecord->delete();

        $this->reset(['studyRecord', 'title', 'description', 'start_datetime', 'end_datetime']);

        $this->loadResult();

        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = $this->userId;

        StudyRecord::create($validatedData);

        $this->reset(['studyRecord', 'title', 'description', 'start_datetime', 'end_datetime']);

        $this->loadResult();

        $this->dispatch('close-modal', 'edit-study-record');

    }

    public function render()
    {
        return view('livewire.study-records-section');
    }
}

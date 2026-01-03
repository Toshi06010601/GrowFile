<?php

namespace App\Livewire\Profile;
use App\Livewire\Profile\ReadingLogSection;
use App\Models\ReadingLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReadingLogForm extends Component
{
    public ?ReadingLog $readingLog;
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $author;

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|string')]
    public $status = 'not_started';

    #[Validate('required|string|max:255')]
    public $cover_url;

    #[Validate('required|string')]
    public $review;

    /*
    Public functions for the modal form
    */
    #[On('set-reading-log')]
    public function setReadingLog($id)
    {
        // 1. If id is passed, find the readingLog and assign each field to public variables 
        if($id) {
            $readingLog          = ReadingLog::findOrFail($id);
            $this->readingLog    = $readingLog;
            $this->title       = $readingLog->title;
            $this->author       = $readingLog->author;
            $this->status       = $readingLog->status;
            $this->cover_url = $readingLog->cover_url;
            $this->review = $readingLog->review;
        } else {
            $this->reset();
        }

        // 2. Reset validation and open readinglog modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-reading-log');
    }

    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();

        // 2. Create new studyrecord and register associated tags
        $this->readingLog = ReadingLog::create($validatedData);

        // 3. Reflect the updates in reading logs section
        $this->dispatch('load-reading-logs')->to(ReadingLogsSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->readingLog);

        // 2. validate the data
        $validateDate = $this->validate();

        // 3. Update the studyrecord and register associated tags
        $this->readingLog->update($validateDate);
        $this->readingLog->tags()->sync($this->selectedTags);

        // 4. Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->readingLog);

        // 2. Delete the record
        $this->readingLog->delete();

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-study-records')->to(StudyRecordsSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-study-record');
    }

    public function render()
    {
        return view('livewire.profile.reading-log-form');
    }
}

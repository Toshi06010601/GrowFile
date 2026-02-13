<?php

namespace App\Livewire\Forms;

use App\Models\StudyRecord;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class StudyRecordForm extends Form
{
    public ?StudyRecord $studyRecord = null;
    public $selectedTags = [];

    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:100')]
    public $category = '';

    #[Validate('nullable|string|max:100')]
    public $activity = '';

    #[Validate('required|date')]
    public $start_datetime = null;

    #[Validate('required|date|after:start_datetime')]
    public $end_datetime = null;

    /*
    Public functions for the modal form
    */
    public function setFields(StudyRecord $studyRecord)
    {
        $this->resetValidation();

        $this->studyRecord = $studyRecord;
 
        $this->fill([
                ...$studyRecord->only('category', 'activity'),
                'start_datetime' => $studyRecord->start_datetime->format('Y-m-d\TH:i'),
                'end_datetime' => $studyRecord->end_datetime->format('Y-m-d\TH:i'),
                'selectedTags' => $studyRecord->tags()->pluck('tags.id')->toArray()
            ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);
            

            // 2. Create new studyRecord
            $this->studyRecord = StudyRecord::create(
                                    $this->only('category', 'activity', 'start_datetime', 'end_datetime') 
                                    + 
                                    ['user_id' => Auth::id()]
                                );
            $this->studyRecord->tags()->sync($this->selectedTags);
     
        });
    }

    public function update()
    {
        DB::transaction(function ()
        {

            
            // 1. Validate
            $this->validate();
            
            // 2. Update studyRecord
            $this->studyRecord->update(
                $this->only('category', 'activity', 'start_datetime', 'end_datetime') 
            );
            // throw new Exception("Error Processing Request", 1);
            $this->studyRecord->tags()->sync($this->selectedTags);
     
        });
    }
}


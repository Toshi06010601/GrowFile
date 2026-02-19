<?php

namespace App\Livewire\ReadingLog;

use App\Models\ReadingLog;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReadingLogForm extends Form
{
    public ?ReadingLog $readingLog = null;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $author = '';

    #[Validate('required|integer|min:0|lte:total_pages')]
    public $current_page = 0;

    #[Validate('required|integer|min:1')]
    public $total_pages = 0;

    #[Validate('required|url|string')]
    public $cover_url = '';

    #[Validate('nullable|string')]
    public $review = '';

    protected function messages()
    {
        return [
            'title.required' => 'Please select book that you would like to register.',
        ];
    }

    /*
    Public functions for the modal form
    */
    public function setFields(ReadingLog $readingLog)
    {
        $this->resetValidation();

        $this->readingLog = $readingLog;
 
        $this->fill([
                ...$readingLog->only('title', 'author', 'current_page', 'total_pages', 'cover_url', 'url'),
            ]);
    }

    public function store()
    {
        // 1. Validate
        $this->validate();
        
        // 2. Create new readingLog
        ReadingLog::create(
            $this->only('title', 'author', 'current_page', 'total_pages', 'cover_url', 'url')
            + 
            ['user_id' => Auth::id()]
        );
    }

    public function update()
    {
        // 1. Validate
        $this->validate();

        // throw new Exception("Error Processing Request", 1);
        

        // 3. Update readingLog
        $this->readingLog->update(
            $this->only('title', 'author', 'current_page', 'total_pages', 'cover_url', 'url')
        );
    }

}


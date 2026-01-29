<?php

namespace App\Livewire\Profile;
use App\Livewire\Profile\ReadingLogSection;
use App\Models\ReadingLog;
use App\Services\GoogleBooksService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Exception;

class ReadingLogForm extends Component
{
    public ?ReadingLog $readingLog = null;
    public $suggestions = [];
    public $search = '';
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:255')]
    public $author = '';

    #[Validate('required|integer|min:1|lte:total_pages')]
    public $current_page = 0;

    #[Validate('required|integer|min:1')]
    public $total_pages = 0;

    #[Validate('required|string')]
    public $cover_url = '';

    #[Validate('string')]
    public $review = '';

    protected function messages()
    {
        return [
            'title.required' => 'Please select book that you would like to register.',
        ];
    }

    /*
      Functions for Reading log form
    */

    #[On('set-reading-log')]
    public function setReadingLog($id, $isOwner)
    {
        $this->reset();

        // 1. If id is passed, find the readingLog and assign each field to public variables 
        if($id) {
            $readingLog          = ReadingLog::findOrFail($id);
            $this->readingLog    = $readingLog;
            $this->fill(
                $readingLog->only('title', 'author', 'current_page', 'total_pages', 'cover_url', 'review')
            );
        }

        // 2. Assign isOwner value
        $this->isOwner = $isOwner;

        // 3. Reset validation and open readinglog modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-reading-log');
    }
    
    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();
        $validatedData['user_id'] = Auth::id();
        
        // 2. 
        try {
            // throw new Exception('Testing error handling');
            // 2.1. Create new reading log
            ReadingLog::create($validatedData);

            // 2.2. Reflect the updates in Reading Log section with flash message
            $this->dispatch('load-reading-logs', type: 'success', message: 'Reading Log created successfully.')->to(ReadingLogSection::class);

        } catch (Exception $e) {
            // 2.1 Reset study record to avoid displaying update and delete buttons
            $this->reset('readingLog');

            // 2.2. Display session flash message and log error 
            session()->flash('error', 'Failed to save reading log. Please try again.');
            logger()->error('Reading log save action failed.', ['error details' => $e->getMessage()]);
            return;
        }
        
        // 3. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');
        
    }
    
    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->readingLog);
        
        // 2. validate the data
        $validatedData = $this->validate();
        
        // 3. 
        try {
            // throw new Exception('Testing error handling');
            // 3.1. Update reading log
            $this->readingLog->update($validatedData);

            // 3.2. Reflect the updates in Reading Log section with flash message
            $this->dispatch('load-reading-logs', 
                    type: 'success', message: 'Reading Log updated successfully.')
                    ->to(ReadingLogSection::class);

        } catch (Exception $e) {
            // 3.1. Display session flash message and log error 
            session()->flash('error', 'Failed to update reading log. Please try again.');
            logger()->error('Reading log update action failed.', ['error details' => $e->getMessage()]);
            return;
        }
        
        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');
    }
    
    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->readingLog);

        // 2. 
        try {
            // throw new Exception('Testing error handling');

            // 2. Delete the record
            $this->readingLog->delete();

            // 2.2. Reflect the updates in Reading Log section with flash message
            $this->dispatch('load-reading-logs', type: 'success', message: 'Reading Log deleted successfully.')->to(ReadingLogSection::class);

        } catch (Exception $e) {
            // 2.1. Display session flash message and log error 
            session()->flash('error', 'Failed to delete reading log. Please try again.');
            logger()->error('Reading log delete action failed.', ['error details' => $e->getMessage()]);
            return;
        }
        
        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');
    }
    

    /*
     Functions for Google Books API 
    */

    // Search books using google books api
    public function updatedSearch (GoogleBooksService $service) {

        if($this->search === "") {
            return;
        }

        try {

            $this->suggestions = $service->search($this->search);

        } catch (Exception $e) {

            session()->flash('error', 'Failed to search books. Please try again.');

        }

    }

    // Select book by getting info from google books api
    public function selectBook($id) {
        
        try {
            
            $service = app(GoogleBooksService::class);
            $bookInfo = $service->selectBook($id);
            $this->fill(
                collect($bookInfo)->only('title', 'author', 'total_pages', 'cover_url')
            );

        } catch (Exception $e) {

            session()->flash('error', 'Failed to select book. Please try again.');
            
        }
        
    }

    public function render()
    {
        return view('livewire.profile.reading-log-form');
    }
}

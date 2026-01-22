<?php

namespace App\Livewire\Profile;
use App\Livewire\Profile\ReadingLogSection;
use App\Models\ReadingLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReadingLogForm extends Component
{
    public ?ReadingLog $readingLog;
    public $suggestions = [];
    public $search = '';
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|string|max:255')]
    public $author;

    #[Validate('required|integer|min:1|lte:total_pages')]
    public $current_page;

    #[Validate('required|integer|min:1')]
    public $total_pages;

    #[Validate('required|string')]
    public $cover_url;

    #[Validate('string')]
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
    #[On('set-reading-log')]
    public function setReadingLog($id, $isOwner)
    {
        // 1. If id is passed, find the readingLog and assign each field to public variables 
        if($id) {
            $readingLog          = ReadingLog::findOrFail($id);
            $this->readingLog    = $readingLog;
            $this->title         = $readingLog->title;
            $this->author        = $readingLog->author;
            $this->current_page   = $readingLog->current_page;
            $this->total_pages    = $readingLog->total_pages;
            $this->cover_url = $readingLog->cover_url;
            $this->review = $readingLog->review;
        } else {
            $this->reset();
        }

        // 2. Assign isOwner value
        $this->isOwner = $isOwner;

        // 3. Reset validation and open readinglog modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-reading-log');
    }

    // Search books using google books api
    public function updatedSearch () {
        $apiUrl = config('services.google_books.api_url');
        $apiKey = config('services.google_books.api_key');

        // GET request
        $response = Http::get($apiUrl, [
            'q' => $this->search,
            'key' => $apiKey,
            'maxResults' => 20,
        ]);
        
        // Response handling
        if ($response->successful()) {
            $this->suggestions = $response->json()['items'] ?? [];
        }
    
        // Error handling
        if ($response->failed()) {
            session()->flash('error', 'Failed to fetch books');
            $this->suggestions = [];
        }

    }

    public function selectBook($id) {
     
        $apiUrl = config('services.google_books.api_url');
        $apiKey = config('services.google_books.api_key');

        // GET request for the specified book 
        $response = Http::get($apiUrl . '/' . $id, [
            'key' => $apiKey
        ]);
        
        // Response handling
        if ($response->successful()) {
            $volumeInfo = $response->json('volumeInfo'); // Convert json into php array

            // Get required data from php array
            $this->title       = data_get($volumeInfo, 'title', 'タイトル不明');
            // If authors is none, give empty array. *Just for info: data_get(target, key, default)
            $this->author = implode(', ', data_get($volumeInfo, 'authors', [])) ?: '著者不明';
            // Get pageCount
            $this->total_pages = data_get($volumeInfo, 'pageCount', 0);
            // Get thumbnail path
            $this->cover_url   = data_get($volumeInfo, 'imageLinks.thumbnail');
            }
    
        // Error handling
        if ($response->failed()) {
            session()->flash('error', 'Failed to fetch books');
            $this->suggestions = [];
        }
    }

    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        // 2. Create new studyrecord and register associated tags
        ReadingLog::create($validatedData);

        // 3. Reflect the updates in reading logs section
        $this->dispatch('load-reading-logs')->to(ReadingLogSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->readingLog);

        // 2. validate the data
        $validatedData = $this->validate();

        // 3. Update the studyrecord and register associated tags
        $this->readingLog->update($validatedData);

        // 4. Reflect the updates in Study records section
        $this->dispatch('load-reading-logs')->to(ReadingLogSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->readingLog);

        // 2. Delete the record
        $this->readingLog->delete();

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-reading-logs')->to(ReadingLogSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-reading-log');
    }

    public function render()
    {
        return view('livewire.profile.reading-log-form');
    }
}

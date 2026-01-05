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
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|string|max:255')]
    public $author;

    #[Validate('required|integer')]
    public $current_page;

    #[Validate('required|integer')]
    public $total_pages;

    #[Validate('required|string|max:255')]
    public $cover_url;

    #[Validate('string')]
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
            $this->title         = $readingLog->title;
            $this->author        = $readingLog->author;
            $this->current_page   = $readingLog->current_page;
            $this->total_pages    = $readingLog->total_pages;
            $this->cover_url = $readingLog->cover_url;
            $this->review = $readingLog->review;
        } else {
            $this->reset();
        }

        // 2. Reset validation and open readinglog modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-reading-log');
    }

    public function updatedSearch () {
        $apiUrl = config('services.google_books.api_url');
        $apiKey = config('services.google_books.api_key');

        // GET request
        $response = Http::get($apiUrl, [
            'q' => $this->search,
            'key' => $apiKey,
            'maxResults' => 20,
        ]);
        
        // レスポンスの処理
        if ($response->successful()) {
            $this->suggestions = $response->json()['items'] ?? [];
        }
    
        // エラーハンドリング
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

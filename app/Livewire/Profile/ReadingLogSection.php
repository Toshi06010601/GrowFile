<?php

namespace App\Livewire\Profile;

use App\Models\ReadingLog;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReadingLogSection extends Component
{
    #[Locked]
    public $userId;
    public $readingLogs;
    #[Locked]
    public $isOwner;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadReadingLogs();
    }

    #[On('load-reading-logs')]
    public function loadReadingLogs($type = '', $message = '') {
        logger()->info('🔄 loadReadingLogs called', ['profileUserId' => $this->userId]);

        try {
            // throw new Exception('Testing error handling');
            $this->readingLogs = ReadingLog::where('user_id', $this->userId)
                ->orderByDesc('updated_at')
                ->get();
    
            // Display success flash message if exists
            session()->flash($type, $message);

        } catch (Exception $e) {
            $this->readingLogs = collect();
            logger()->error('Failed to load reading logs', ['error' => $e->getMessage(), 'profileUserId' => $this->userId]);
            session()->flash('error', 'Failed to load reading logs.');
        }
    }

    public function render()
    {
        return view('livewire.profile.reading-log-section');
    }
}

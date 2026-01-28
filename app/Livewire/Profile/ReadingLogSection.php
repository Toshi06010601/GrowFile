<?php

namespace App\Livewire\Profile;

use App\Models\ReadingLog;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ReadingLogSection extends Component
{
    public $userId;
    public $readingLogs;
    public $isOwner;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadReadingLogs();
    }

    #[On('load-reading-logs')]
    public function loadReadingLogs($type = '', $message = '') {
        logger()->info('🔄 loadReadingLogs called', ['profileUserId' => $this->userId]);

        $this->readingLogs = ReadingLog::where('user_id', $this->userId)
            ->orderByDesc('updated_at')
            ->get();

        // Display success flash message if exists
        session()->flash($type, $message);
    }

    public function render()
    {
        return view('livewire.profile.reading-log-section');
    }
}

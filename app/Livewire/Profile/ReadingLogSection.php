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

    public function loadReadingLogs() {
        $this->readingLogs = ReadingLog::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.reading-log-section');
    }
}

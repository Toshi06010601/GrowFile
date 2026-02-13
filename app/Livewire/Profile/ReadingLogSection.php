<?php

namespace App\Livewire\Profile;

use App\Models\ReadingLog;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReadingLogSection extends Component
{
    #[Locked]
    public $userId;
    #[Locked]
    public $isOwner;
    public $hasError = false;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
    }

    #[Computed] 
    public function readingLogs()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading reading logs', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return ReadingLog::where('user_id', $this->userId)
                                ->orderByDesc('updated_at')
                                ->limit(0)
                                ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load reading logs', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }

    #[On('reading-logs-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching reading logs', ['profileUserId' => $this->userId]);
        unset($this->readingLogs); // Refresh reaindLogs
    }

    public function render()
    {
        $this->readingLogs;
        return view('livewire.profile.reading-log-section');
    }
}

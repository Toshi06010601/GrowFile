<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class CourseSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $hasError = false;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
    }

    #[Computed] 
    public function courses()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading courses', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return Course::where('user_id', $this->userId)
                                ->orderByDesc('updated_at')
                                ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load courses', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }

    #[On('courses-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching courses', ['profileUserId' => $this->userId]);
        unset($this->courses); // Refresh courses
    }

    public function render()
    {
        $this->courses;
        return view('livewire.course.section');
    }
}

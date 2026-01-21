<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Course;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CourseSection extends Component
{
    public $userId;
    public $courses;
    public $isOwner;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->loadCourses();
    }

    #[On('load-courses')]
    public function loadCourses() {
        logger('🔄 loadCourses called', ['profileUserId' => $this->userId]);
        $this->courses = Course::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
    }

    public function render()
    {
        return view('livewire.profile.course-section');
    }
}

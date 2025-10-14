<?php
namespace App\Livewire;

use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class StudyRecordsSection extends Component
{
    public $records = [];

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadResult();
    }

    #[On('load-study-records')]
    public function loadResult()
    {
        $this->records = StudyRecord::with('tags')
            ->where('user_id', Auth::id())
            ->orderByDesc('start_datetime')
            ->get();
    }

    public function render()
    {
        return view('livewire.study-records-section');
    }
}

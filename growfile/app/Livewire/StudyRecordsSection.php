<?php
namespace App\Livewire;

use App\Models\StudyRecord;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class StudyRecordsSection extends Component
{
    /*
    Public variables for the section area
    */
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
        $this->records = StudyRecord::where('user_id', Auth::id())
            ->orderByDesc('start_datetime')
            ->get();
    }

    public function render()
    {
        return view('livewire.study-records-section');
    }
}

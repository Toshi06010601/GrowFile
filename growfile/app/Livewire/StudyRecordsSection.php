<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\StudyRecord;
use Livewire\Attributes\Validate; 

class StudyRecordsSection extends Component
{
    public $userId  = '';
    public $records = [];

    // form fields
    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('string')]
    public $description = '';

    #[Validate('required|date')]
    public $start_datetime = null;

    #[Validate('required|date')]
    public $end_datetime = null;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadResult();
    }

    public function loadResult()
    {
        $this->records = StudyRecord::where('user_id', $this->userId)
            ->orderByDesc('start_datetime')
            ->get();
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = $this->userId;

        StudyRecord::create($validatedData);

        $this->reset(['title', 'description', 'start_datetime', 'end_datetime']);

        $this->loadResult();

    }

    public function render()
    {
        return view('livewire.study-records-section');
    }
}

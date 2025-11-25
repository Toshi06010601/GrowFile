<?php
namespace App\Livewire;

use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class StudyRecordsSection extends Component
{
    use WithPagination;

    public $userId;
    public $isOwner;
    public $perPage;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->perPage = 20;
        $this->isOwner = Auth::id() === $this->userId;
    }

    #[On('load-study-records')]
    public function refreshRecords()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function render()
    {
        return view('livewire.profile.study-records-section', [
            'records' => StudyRecord::with('tags')
            ->where('user_id', $this->userId)
            ->orderByDesc('start_datetime')
            ->Paginate($this->perPage)
        ]);
    }
}

<?php
namespace App\Livewire\Profile;

use App\Models\StudyRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Exception;

class StudyRecordsSection extends Component
{
    use WithPagination;

    /*
    Public variables for the section area
    */
    #[Locked]
    public $userId;
    #[Locked]
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
    public function refreshRecords($type = '', $message = '')
    {
        // Display success flash message if exists
        session()->flash($type, $message);

        // Return to the first page of studyrecords
        $this->resetPage();
    }
    
    public function loadMore()
    {
        $this->perPage += 20;
    }
    
    public function render()
    {
        logger()->info('🔄 loading StudyRecords', ['profileUserId' => $this->userId]);

        try {
            // throw new Exception('Testing error handling');
            // Passing studyrecords with view method to use Pagination
            return view('livewire.profile.study-records-section', [
                'records' => StudyRecord::with('tags')
                ->where('user_id', $this->userId)
                ->orderByDesc('start_datetime')
                ->paginate($this->perPage)
            ]);
        } catch (Exception $e) {
            logger()->error('Failed to load study records', ['error' => $e->getMessage(), 'profileUserId' => $this->userId]);
            session()->flash('error', 'Failed to load study records.');
            return view('livewire.profile.study-records-section', ['records' => collect()]);
        }
        
    }
}

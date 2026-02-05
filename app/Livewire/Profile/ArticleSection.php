<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class ArticleSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $lastUpdated = null;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->lastUpdated = now()->timestamp;
    }

    #[Computed] 
    public function articles()
    {
        logger()->info('🔄 loadind articles', ['profileUserId' => $this->userId]);
        return Article::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
    }

    #[On('articles-updated')]
    public function refetch($type = '', $message = '') {  
        
        // Display flash message for successful action
         if ($type && $message) {
            session()->flash($type, $message);
        }
        
        logger()->info('🔄 Refetching articles', ['profileUserId' => $this->userId]);
        $this->lastUpdated = now()->timestamp; // Refresh splide instance
        unset($this->articles); // Refresh articles
    }

    public function render()
    {
        return view('livewire.profile.article-section');
    }
}

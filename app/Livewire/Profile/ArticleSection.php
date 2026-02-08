<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Exception;

class ArticleSection extends Component
{
    #[Locked]
    public $userId = null;
    #[Locked]
    public $isOwner = false;
    public $lastUpdated = null;
    public $hasError = false;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->lastUpdated = now()->timestamp;
    }

    #[Computed] 
    public function articles()
    {
        try {
            // throw new exception('error');
            logger()->info('🔄 loading articles', ['profileUserId' => $this->userId]);
            $this->hasError = false;
            return Article::where('user_id', $this->userId)
                                ->orderByDesc('updated_at')
                                ->get();
        } catch (Exception $e) {
            logger()->error('Failed to load articles', ['profileUserId' => $this->userId, 'error' => $e->getMessage()]);
            $this->hasError = true;
            return collect();
        }
    }
    
    #[On('articles-updated')]
    public function refetch() {
        logger()->info('🔄 Refetching articles', ['profileUserId' => $this->userId]);
        $this->lastUpdated = now()->timestamp; // Refresh splide instance
        unset($this->articles); // Refresh articles
    }

    public function render()
    {
        $this->articles;
        return view('livewire.profile.article-section');
    }
}

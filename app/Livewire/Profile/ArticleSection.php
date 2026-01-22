<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ArticleSection extends Component
{
    public $userId;
    public $articles;
    public $isOwner;
    public $lastUpdated;

    public function mount($userId) {
        $this->userId = $userId;
        $this->isOwner = Auth::id() === $this->userId;
        $this->lastUpdated = now()->timestamp;
        $this->loadArticle();
    }

    #[On('load-articles')]
    public function loadArticle() {
        logger()->info('🔄 loadArticle called', ['profileUserId' => $this->userId]);
        $this->articles = Article::where('user_id', $this->userId)
                            ->orderByDesc('updated_at')
                            ->get();
        $this->lastUpdated = now()->timestamp;
    }

    public function render()
    {
        return view('livewire.profile.article-section');
    }
}

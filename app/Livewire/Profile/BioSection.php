<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BioSection extends Component
{
    public $profile;
    public $userId;

    /*
    Public function for the section area
    */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadBio();
    }

    #[On('load-bio')]
    public function loadBio()
    {
        // Get the profile with bio
        logger()->info('🔄 loadBio called', ['profileUserId' => $this->userId]);
        $this->profile = Profile::select('id', 'user_id', 'bio')
                        ->firstWhere('user_id', $this->userId);
    }

    public function render()
    {
        return view('livewire.profile.bio-section');
    }
}

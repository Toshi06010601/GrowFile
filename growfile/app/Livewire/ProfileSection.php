<?php

namespace App\Livewire;
use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileSection extends Component
{

    public $profile;
    public $shortBio;

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadResult();
    }

    #[On('load-profile')]
    public function loadResult()
    {
        $this->profile = Profile::where('user_id', Auth::id())
            ->first();
        $this->shortBio = Str::limit($this->profile->bio, 200, '...');
    }

    public function render()
    {
        return view('livewire.profile-section');
    }
}

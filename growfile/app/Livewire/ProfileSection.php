<?php

namespace App\Livewire;
use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ProfileSection extends Component
{

    public $profile;

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
        if($this->profile->slug === "test_user.co") {
            $this->js('console.log("profile exists");');
        }
    }

    public function render()
    {
        return view('livewire.profile-section');
    }
}

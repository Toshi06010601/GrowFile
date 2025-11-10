<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BioSection extends Component
{
    public $profile;

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadBio();
    }

    #[On('load-bio')]
    public function loadBio()
    {
        $this->profile = Profile::where('user_id', Auth::id())
            ->select('id', 'bio')
            ->first();
    }

    public function render()
    {
        return view('livewire.bio-section');
    }
}

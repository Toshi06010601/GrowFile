<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class BackgroundSection extends Component
{
    public $profile;

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadBackground();
    }

    #[On('load-background')]
    public function loadBackground()
    {
        $this->profile = Profile::where('user_id', Auth::id())
            ->select('id', 'background_image_path')
            ->first();
    }

    public function render()
    {
        return view('livewire.background-section');
    }
}

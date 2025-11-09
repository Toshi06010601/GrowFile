<?php

namespace App\Livewire;

use App\Models\Experience;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExperiencesSection extends Component
{

    public $experiences;

    /*
    Public function for the section area
    */
    public function mount()
    {
        $this->loadExperiences();
    }

    #[On('load-experiences')]
    public function loadExperiences()
    {
        $this->experiences = Experience::where('user_id', Auth::id())
                            ->get();
    }

    public function render()
    {
        return view('livewire.experiences-section');
    }
}

<?php

namespace App\Livewire;
use App\Models\Profile;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileSection extends Component
{

    public $profile;
    public $profileId;

    /*
    Public function for the section area
    */
    public function mount($profileId)
    {
        $this->profileId = $profileId;

        $this->loadResult();

        // For debug
        // $id = Auth::id();
        // $this->js("console.log($id);");
        // $user_id = $this->profile->user_id;
        // $this->js("console.log($user_id);");
        
        $this->dispatch('set-profile-menu-icon', ['filePath' => $this->profile->profile_image_path]);
    }

    #[On('load-profile')]
    public function loadResult()
    {
        $this->profile = Profile::find($this->profileId);
    }

    public function render()
    {
        return view('livewire.profile-section');
    }
}

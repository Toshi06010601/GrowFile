<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public $userId; // ID of the user whose profile we are on
    public $isFollowing;
    public $idPrefix;

    public function mount($userId, $isFollowing, $idPrefix)
    {
        $this->userId = $userId;
        $this->isFollowing = $isFollowing;
        $this->idPrefix = $idPrefix;
    }

    public function updatedIsFollowing() {
        //When changed to Not following
        if(!$this->isFollowing) {
            //delete follow record
            Follow::where('follower_id', Auth::id())
            ->where('followed_id', $this->userId)
            ->delete();

          //When changed to Following
        } else {
            //Create follow record
            Follow::create([
                'follower_id' => Auth::id(),
                'followed_id' => $this->userId
            ]);
        }
    }


    public function render()
    {
        return view('livewire.follow-button');
    }
}

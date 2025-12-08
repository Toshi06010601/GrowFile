<?php
// app/View/Components/ProfileFilter.php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfileFilter extends Component
{
    public $groupedSkills;
    public $selectedSkills;
    public $name;
    public $location;
    public $following;
    public $followed;
    public $idPrefix; // For unique IDs

    public function __construct(
        $groupedSkills,
        $selectedSkills = [],
        $name = '',
        $location = '',
        $following = false,
        $followed = false,
        $idPrefix = ''
    ) {
        $this->groupedSkills = $groupedSkills;
        $this->selectedSkills = $selectedSkills;
        $this->name = $name;
        $this->location = $location;
        $this->following = $following;
        $this->followed = $followed;
        $this->idPrefix = $idPrefix;
    }

    public function render()
    {
        return view('components.profile-filter');
    }
}
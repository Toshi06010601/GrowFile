<?php

namespace App\Livewire\Profile;
use App\Livewire\Profile\PortfolioSection;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PortfolioForm extends Component
{
    public ?Portfolio $portfolio;
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('string')]
    public $description = '';

    #[Validate('string')]
    public $site_url = '';

    #[Validate('string')]
    public $site_image_path = '';
    
    #[Validate('string')]
    public $github_url = '';

    #[Validate('string')]
    public $comment = '';

    /*
    Public functions for the modal form
    */
    #[On('set-portfolio')]
    public function setPortfolio($id, $isOwner)
    {
        // 1. If id is passed, find the Portfolio and assign each field to public variables 
        if($id) {
            $portfolio          = Portfolio::findOrFail($id);
            $this->Portfolio    = $portfolio;
            $this->title         = $portfolio->title;
            $this->description        = $portfolio->description;
            $this->site_url   = $portfolio->site_url;
            $this->site_image_path    = $portfolio->site_image_path;
            $this->github_url = $portfolio->github_url;
            $this->comment = $portfolio->comment;
        } else {
            $this->reset();
        }

        // 2. Assign isOwner value
        $this->isOwner = $isOwner;

        // 3. Reset validation and open Portfolio modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-portfolio');
    }

    public function save()
    {
        // 1. Validate and prepare the data
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        // 2. Create new studyrecord and register associated tags
        Portfolio::create($validatedData);

        // 3. Reflect the updates in reading logs section
        $this->dispatch('load-portfolio')->to(PortfolioSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-portfolio');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->Portfolio);

        // 2. validate the data
        $validatedData = $this->validate();

        // 3. Update the studyrecord and register associated tags
        $this->Portfolio->update($validatedData);

        // 4. Reflect the updates in Study records section
        $this->dispatch('load-portfolio')->to(PortfolioSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-portfolio');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->Portfolio);

        // 2. Delete the record
        $this->Portfolio->delete();

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-portfolio')->to(PortfolioSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-portfolio');
    }



    public function render()
    {
        return view('livewire.profile.portfolio-form');
    }
}

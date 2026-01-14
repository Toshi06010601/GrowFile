<?php

namespace App\Livewire\Profile;
use App\Livewire\Profile\PortfolioSection;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioForm extends Component
{
    use WithFileUploads;
    public ?Portfolio $portfolio;
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    public $site_image;       // Holds the temporary uploaded file object

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
            $this->portfolio    = $portfolio;
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
        // 1. Update site_image_path if new site image uploaded
        if ($this->site_image) {
            // 1.1. Store the old site name
            $oldFileName =  str_replace('storage/', '', $this->site_image_path);

            // 1.2. Validate newly uploaded image
            $this->validate(['site_image' => 'image|max:1024']);

            // 1.3. Construct new file name and assign it to site image path
            $newFileName = (string) Str::uuid() . '.' .  $this->site_image->getClientOriginalExtension();
            $this->site_image_path = "/storage/site_photos/" . $newFileName;

            // 1.4. Save site_image to the folder
            $this->site_image->storeAs(path: 'site_photos', name: $newFileName);

            // 1.5. Delete old image file except for the default image
            if($oldFileName !== "/site_photos/default.jpg") {
                Storage::disk('public')->delete($oldFileName);
            }
        }

        // 2. Validate and prepare the data
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        // 3. Create new studyrecord and register associated tags
        Portfolio::create($validatedData);

        // 4. Reflect the updates in reading logs section
        $this->dispatch('load-portfolios')->to(PortfolioSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-portfolio');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->portfolio);

        // 2. Update site_image_path if new site image uploaded
        if ($this->site_image) {
            // 2.1. Store the old site name
            $oldFileName =  str_replace('storage/', '', $this->site_image_path);

            // 2.2. Validate newly uploaded image
            $this->validate(['site_image' => 'image|max:1024']);

            // 2.3. Construct new file name and assign it to site image path
            $newFileName = (string) Str::uuid() . '.' .  $this->site_image->getClientOriginalExtension();
            $this->site_image_path = "/storage/site_photos/" . $newFileName;

            // 2.4. Save site_image to the folder
            $this->site_image->storeAs(path: 'site_photos', name: $newFileName);

            // 2.5. Delete old image file except for the default image
            if($oldFileName !== "/site_photos/default.jpg") {
                Storage::disk('public')->delete($oldFileName);
            }
        }
        
        // 2. validate the data
        $validatedData = $this->validate();

        // 3. Update the studyrecord and register associated tags
        $this->portfolio->update($validatedData);

        // 4. Reflect the updates in Study records section
        $this->dispatch('load-portfolios')->to(PortfolioSection::class);

        // 5. Clean up the modal form and close the modal
        // $this->reset();
        $this->reset(['title', 'description', 'site_url', 'github_url', 'comment', 'site_image', 'site_image_path']);
        $this->dispatch('close-modal', 'edit-portfolio');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->portfolio);

        // 2. Delete the record
        $this->portfolio->delete();

        // 3. Reflect the updates in Study records section
        $this->dispatch('load-portfolios')->to(PortfolioSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-portfolio');
    }



    public function render()
    {
        return view('livewire.profile.portfolio-form');
    }
}

<?php

namespace App\Livewire\Forms;

use App\Models\Portfolio;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use App\Traits\HasImageUpload;
use Illuminate\Support\Facades\Auth;
use Exception;

class PortfolioForm extends Form
{
    use HasImageUpload;

    public ?Portfolio $portfolio = null;

    #[Validate('nullable|mimes:jpg,jpeg,png,webp|max:1024')]
    public $site_image = null;       // Holds the temporary uploaded file object

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('nullable|string|url|max:500')]
    public $site_url = '';

    #[Validate('nullable|string')]
    public $site_image_path = '';
    
    #[Validate('nullable|string|url|max:500')]
    public $github_url = '';

    #[Validate('nullable|string')]
    public $comment = '';

    /*
    Public functions for the modal form
    */
    public function setFields(Portfolio $portfolio)
    {
        $this->resetValidation();

        $this->portfolio = $portfolio;
 
        $this->fill([
                ...$portfolio->only('title', 'description', 'site_url', 'site_image_path', 'github_url', 'comment')
            ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);
            
            // 2. Upload Image
            $this->uploadSiteImage();

            // 3. Create new portfolio
            Portfolio::create(
                $this->only('title', 'description', 'site_url', 'site_image_path', 'github_url', 'comment')
                + 
                ['user_id' => Auth::id()]
            );
     
        });
    }

    public function update()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // throw new Exception("Error Processing Request", 1);
            

            // 2. Upload Image
            $this->uploadSiteImage();

            // 3. Update portfolio
            $this->portfolio->update(
                $this->only('title', 'description', 'site_url', 'site_image_path', 'github_url', 'comment')
            );
     
        });
    }

    /*
    Protected functions for the modal form
    */
    protected function uploadSiteImage()
    {
        if (!$this->site_image) {
            return;
        }

        $oldPath = $this->site_image_path;

        // 1. Upload new image and store file path
        $this->site_image_path = $this->uploadNewImage(
            $this->site_image,
            'site_photos',
            $oldPath
        );

        // 2. Delete old image if successfull
        DB::aftercommit(fn() => $this->deleteOldImage( $oldPath, '/default.jpg' ));
    }

}

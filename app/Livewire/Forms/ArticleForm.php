<?php

namespace App\Livewire\Forms;

use App\Models\Article;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\DB;
use App\Traits\HasImageUpload;
use Illuminate\Support\Facades\Auth;
use Exception;

class ArticleForm extends Form
{
    use HasImageUpload;

    public ?Article $article = null;

    #[Validate('nullable|mimes:jpg,jpeg,png,webp|max:1024')]
    public $article_image = null;       // Holds the temporary uploaded file object

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('nullable|string|url|max:500')]
    public $article_url = '';

    #[Validate('nullable|string')]
    public $article_image_path = '';

    #[Validate('required|string|max:100')]
    public $platform_name = '';
    
    #[Validate('required|date')]
    public $published_date = null;

    /*
    Public functions for the modal form
    */
    public function setFields(Article $article)
    {
        $this->resetValidation();

        $this->article = $article;
 
        $this->fill([
                ...$article->only('title', 'description', 'article_url', 'article_image_path', 'platform_name'),
                'published_date' => $article->published_date ? $article->published_date->format('Y-m-d') : null,
            ]);
    }

    public function store()
    {
        DB::transaction(function ()
        {
            // 1. Validate
            $this->validate();

            // 2. Upload Image
            $this->uploadArticleImage();

            // 3. Create new article
            Article::create(
                $this->only('title', 'description', 'article_url', 'article_image_path', 'platform_name', 'published_date') 
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

            // 2. Upload Image
            $this->uploadArticleImage();

            // 3. Update article
            $this->article->update(
                $this->only('title', 'description', 'article_url', 'article_image_path', 'platform_name', 'published_date')
            );
     
        });
    }

    /*
    Protected functions for the modal form
    */
    protected function uploadArticleImage()
    {
        if (!$this->article_image) {
            return;
        }

        $oldPath = $this->article_image_path;

        // 1. Upload new image and store file path
        $this->article_image_path = $this->uploadNewImage(
            $this->article_image,
            'article_photos',
            $oldPath
        );

        // 2. Delete old image if successfull
        DB::aftercommit(fn() => $this->deleteOldImage( $oldPath, '/default.jpg' ));
    }

}

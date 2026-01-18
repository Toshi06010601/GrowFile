<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\ArticleSection;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleForm extends Component
{
    use WithFileUploads;
    public ?Article $article;
    public $isOwner = false;
 
    /*
    Public variables for the modal form
    */
    public $article_image;       // Holds the temporary uploaded file object

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('string')]
    public $description = '';

    #[Validate('string')]
    public $article_url = '';

    #[Validate('string')]
    public $article_image_path = '';

    #[Validate('string')]
    public $platform_name = '';
    
    #[Validate('date')]
    public $published_date = null;

    /*
    Public functions for the modal form
    */
    #[On('set-article')]
    public function setArticle($id, $isOwner)
    {
        // 1. If id is passed, find the Article and assign each field to public variables 
        if($id) {
            $article          = Article::findOrFail($id);
            $this->article    = $article;
            $this->title         = $article->title;
            $this->description        = $article->description;
            $this->article_url   = $article->article_url;
            $this->article_image_path    = $article->article_image_path;
            $this->platform_name = $article->platform_name;
            $this->published_date = $article->published_date ? $article->published_date->format('Y-m-d') : null;
        } else {
            $this->reset();
        }

        // 2. Assign isOwner value
        $this->isOwner = $isOwner;

        // 3. Reset validation and open Article modal
        $this->resetValidation();
        $this->dispatch('open-modal', 'edit-article');
    }

    public function save()
    {
        // 1. Update article_image_path if new site image uploaded
        if ($this->article_image) {
            // 1.1. Store the old site name
            $oldFileName =  str_replace('storage/', '', $this->article_image_path);

            // 1.2. Validate newly uploaded image
            $this->validate(['article_image' => 'image|max:1024']);

            // 1.3. Construct new file name and assign it to site image path
            $newFileName = (string) Str::uuid() . '.' .  $this->article_image->getClientOriginalExtension();
            $this->article_image_path = "/storage/article_photos/" . $newFileName;

            // 1.4. Save article_image to the folder
            $this->article_image->storeAs(path: 'article_photos', name: $newFileName);

            // 1.5. Delete old image file except for the default image
            if($oldFileName !== "/article_photos/default.jpg") {
                Storage::disk('public')->delete($oldFileName);
            }
        }

        // 2. Validate and prepare the data
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        // 3. Create new article and register associated tags
        Article::create($validatedData);

        // 4. Reflect the updates in reading logs section
        $this->dispatch('load-articles')->to(ArticleSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-article');

    }

    public function update()
    {
        // 1. Authorize 
        $this->authorize('update', $this->article);

        // 2. Update article_image_path if new site image uploaded
        if ($this->article_image) {
            // 2.1. Store the old site name
            $oldFileName =  str_replace('storage/', '', $this->article_image_path);

            // 2.2. Validate newly uploaded image
            $this->validate(['article_image' => 'image|max:1024']);

            // 2.3. Construct new file name and assign it to site image path
            $newFileName = (string) Str::uuid() . '.' .  $this->article_image->getClientOriginalExtension();
            $this->article_image_path = "/storage/article_photos/" . $newFileName;

            // 2.4. Save article_image to the folder
            $this->article_image->storeAs(path: 'article_photos', name: $newFileName);

            // 2.5. Delete old image file except for the default image
            if($oldFileName !== "/article_photos/default.jpg") {
                Storage::disk('public')->delete($oldFileName);
            }
        }
        
        // 2. validate the data
        $validatedData = $this->validate();

        // 3. Update the article and register associated tags
        $this->article->update($validatedData);

        // 4. Reflect the updates in Article section
        $this->dispatch('load-articles')->to(ArticleSection::class);

        // 5. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-article');
    }

    public function delete()
    {
        // 1. Authorize the data
        $this->authorize('delete', $this->article);

        // 2. Delete the record
        $this->article->delete();

        // 3. Reflect the updates in Article section
        $this->dispatch('load-articles')->to(ArticleSection::class);

        // 4. Clean up the modal form and close the modal
        $this->reset();
        $this->dispatch('close-modal', 'edit-article');
    }

    public function render()
    {
        return view('livewire.profile.article-form');
    }
}

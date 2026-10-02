<?php

namespace App\Actions\storeAction;

use Illuminate\Support\Facades\Auth;
use App\Livewire\Article\ArticleForm;
use App\Services\Storage\;

class saveAction
{
    public function __constructor(ArticleForm $form, )
    {
        $this->form = $form;
    }

    public function __invoke(): void
    {
        DB::transaction(function ()
        {
            $this->uploadArticleImage();

            // 3. Create new article
            Article::create(
                $this->only('title', 'description', 'article_url', 'article_image_path', 'platform_name', 'published_date') 
                + 
                ['user_id' => Auth::id()]
            );
     
        });

    }
}
<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\ArticleSection;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Livewire\Forms\ArticleForm;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Livewire\WithFileUploads;
use Illuminate\Validation\ValidationException; 
use Exception;

class ArticleEditor extends Component
{
    use WithFileUploads;

    public ArticleForm $form;

    #[Locked]
    public $isOwner = false;

    /*
    Public functions for the modal form
    */
    #[On('set-article')]
    public function setArticle($id)
    {
        $this->form->reset();
        $this->form->resetValidation();

        if($id) {
            $article = Article::findOrFail($id);
            $this->isOwner = Auth::id() === $article->user_id;
            $this->form->setFields($article);
        } else {
            $this->isOwner = Auth::check();
        }

        $this->dispatch('open-modal', 'edit-article');
    }

    public function save()
    {
        $isUpdate = (bool) $this->form->article;
        
        try {
            // throw new Exception('Testing error handling');
            $isUpdate && $this->authorize('update', $this->form->article);
            $isUpdate ? $this->form->update() : $this->form->store();
            $this->finishAction($isUpdate ? 'updated' : 'created');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError($isUpdate ? 'update' : 'create', $e);
        }
    }
    
    public function delete()
    {
        try {
            $this->authorize('delete', $this->form->article);
            $this->form->article->delete();
            $this->finishAction('deleted');
    
        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }   
    }

    /*
    Private functions for the modal form
    */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('articles-updated', 
            type: 'success', 
            message: "Article {$actionName} successfully."
        )->to(ArticleSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-article');
    }

    private function handleError(string $actionName, Exception $e): void
    {
        session()->flash('error', "Failed to {$actionName} article. Please try again.");
        $this->dispatch('flash-message');
        logger()->error("Article {$actionName} action failed.", ['error' => $e->getMessage()]);
    }

    public function render()
    {
        return view('livewire.profile.article-editor');
    }
}

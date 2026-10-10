<?php

namespace App\Livewire\Article;

use App\Models\Article;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Modal form for creating, editing and deleting articles.
 *
 * Opened by the `set-article` event from the article section. On success it
 * notifies {@see ArticleSection} via `articles-updated` so the list refreshes,
 * closes the `edit-article` modal and shows a flash message.
 */
class ArticleEditor extends Component
{
    use WithFileUploads;

    public ArticleForm $form;

    #[Locked]
    public bool $isOwner = false;

    /*
    Public functions for the modal form
    */

    /**
     * Load an article into the form and open the modal.
     *
     * Passing an ID loads that article for editing; passing null opens an empty
     * form for a new article. Shows an error flash message if the article cannot be loaded.
     *
     * @param  int|null  $id  The article ID, or null to create a new article.
     */
    #[On('set-article')]
    public function setArticle(?int $id): void
    {
        try {
            $this->form->reset();
            $this->form->resetValidation();

            if ($id) {
                $article = Article::findOrFail($id);
                $this->isOwner = Auth::id() === $article->user_id;
                $this->form->setFields($article);
            } else {
                $this->isOwner = Auth::check();
            }

            $this->dispatch('open-modal', 'edit-article');

        } catch (ModelNotFoundException $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.article.not-found'));
            logger()->warning('Article not found', ['article_id' => $id]);
        } catch (Exception $e) {
            $this->dispatch('flash-message', type: 'error', message: __('flash.article.failed-load'));
            logger()->error('Failed to load article modal', ['id' => $id, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Create a new article, or update the loaded one after checking the policy.
     *
     * Validation errors are rethrown so Livewire shows them on the form; any other
     * failure (including a failed authorization) is logged and shown as a flash message.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(): void
    {
        $isUpdate = (bool) $this->form->article;

        try {
            $isUpdate && $this->authorize('update', $this->form->article);
            $isUpdate ? $this->form->update() : $this->form->store();
            $this->finishAction($isUpdate ? 'updated' : 'created');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            $this->handleError($isUpdate ? 'update' : 'create', $e);
        }
    }

    /**
     * Delete the loaded article after checking the policy.
     *
     * Any failure (including a failed authorization) is logged and shown as a flash message.
     */
    public function delete(): void
    {
        try {
            $this->authorize('delete', $this->form->article);
            $this->form->article->delete();
            $this->finishAction('deleted');

        } catch (Exception $e) {
            $this->handleError('delete', $e);
        }
    }

    public function render(): View
    {
        return view('livewire.article.editor');
    }

    /*
    Private functions for the modal form
    */

    /**
     * Refresh the article list, reset and close the modal, and flash a success message.
     *
     * @param  'created'|'updated'|'deleted'  $actionName  Suffix of the `flash.article.*` translation key.
     */
    private function finishAction(string $actionName): void
    {
        $this->dispatch('articles-updated')->to(component: ArticleSection::class);
        $this->form->reset();
        $this->dispatch('close-modal', 'edit-article');
        $this->dispatch('flash-message', type: 'success', message: __("flash.article.{$actionName}"));
    }

    /**
     * Flash an error message and log the exception for a failed action.
     *
     * @param  'create'|'update'|'delete'  $actionName  Used to build the `flash.article.failed-*` translation key.
     */
    private function handleError(string $actionName, Exception $e): void
    {
        $this->dispatch('flash-message', type: 'error', message: __("flash.article.failed-{$actionName}"));
        logger()->error("Article {$actionName} action failed.", ['error' => $e->getMessage()]);
    }
}

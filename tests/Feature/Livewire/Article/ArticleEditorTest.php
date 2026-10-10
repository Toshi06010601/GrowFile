<?php

namespace Tests\Feature\Livewire\Article;

use App\Livewire\Article\ArticleEditor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_renders(): void
    {
        Livewire::test(ArticleEditor::class)
            ->assertOk();
    }

    public function test_opening_new_article_form_as_logged_in_user_sets_owner(): void
    {
        Livewire::actingAs(User::factory()->create())
            ->test(ArticleEditor::class)
            ->dispatch('set-article', id: null)
            ->assertSet('isOwner', true)
            ->assertDispatched('open-modal', 'edit-article');
    }

    public function test_opening_new_article_form_as_guest_does_not_set_owner(): void
    {
        Livewire::test(ArticleEditor::class)
            ->dispatch('set-article', id: null)
            ->assertSet('isOwner', false)
            ->assertDispatched('open-modal', 'edit-article');
    }

    public function test_opening_missing_article_shows_not_found_message(): void
    {
        Livewire::actingAs(User::factory()->create())
            ->test(ArticleEditor::class)
            ->dispatch('set-article', id: 999999)
            ->assertNotDispatched('open-modal')
            ->assertDispatched('flash-message', type: 'error', message: __('flash.article.not-found'));
    }
}

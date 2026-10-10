<?php

namespace Tests\Feature\Layouts;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_links_to_profile_creation_when_user_has_no_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en')
            ->assertOk()
            ->assertSee(route('professional_profile.create', ['locale' => 'en']), false);
    }

    public function test_settings_page_renders_when_user_has_no_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/en/profile')
            ->assertOk()
            ->assertSee(route('professional_profile.create', ['locale' => 'en']), false);
    }

    public function test_home_page_links_to_own_profile_when_user_has_profile(): void
    {
        $profile = Profile::factory()->create();

        $this->actingAs($profile->user)
            ->get('/en')
            ->assertOk()
            ->assertSee(route('professional_profile.show', ['locale' => 'en', 'slug' => $profile->slug]), false)
            ->assertDontSee(route('professional_profile.create', ['locale' => 'en']), false);
    }
}

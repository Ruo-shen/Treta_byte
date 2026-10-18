<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class InnerKitTest extends TestCase
{
    use RefreshDatabase;

    public function test_placeholder_renders_nothing_outside_local(): void
    {
        $this->assertSame('', trim(Blade::render('<x-inner.placeholder what="a client logo" />')));

        $this->app['env'] = 'local';
        $this->assertStringContainsString('Content needed: a client logo', Blade::render('<x-inner.placeholder what="a client logo" />'));
    }

    public function test_placeholders_never_leak_into_public_pages_in_testing(): void
    {
        foreach (['/work', '/about', '/contact', '/privacy', '/services/web-development'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('Content needed');
        }
    }

    public function test_homepage_keeps_its_own_cta_partial(): void
    {
        $this->assertFileExists(resource_path('views/components/cta.blade.php'));
        $this->get('/')->assertOk()->assertSee('Have something that needs');
    }

    public function test_reading_minutes_is_stored_on_save_and_refreshed_when_content_changes(): void
    {
        $post = Post::factory()->create(['content' => '<p>'.implode(' ', array_fill(0, 500, 'word')).'</p>']);
        $this->assertSame(3, $post->fresh()->reading_minutes);

        $post->update(['content' => '<p>short</p>']);
        $this->assertSame(1, $post->fresh()->reading_minutes);
    }

    public function test_article_title_gets_the_site_suffix_unless_a_seo_title_is_set(): void
    {
        $plain = Post::factory()->published()->create(['title' => 'Plain article']);
        $custom = Post::factory()->published()->create(['title' => 'Other', 'seo_title' => 'Custom SEO title']);

        $this->get("/blog/{$plain->slug}")->assertSee('<title>Plain article — '.config('app.name').'</title>', false);
        $this->get("/blog/{$custom->slug}")->assertSee('<title>Custom SEO title</title>', false);
    }

    public function test_contact_preselects_general_for_an_unknown_topic(): void
    {
        $this->get('/contact?topic=bogus')->assertSee('<option value="general" selected>', false);
        $this->get('/contact?topic=fix')->assertSee('<option value="fix" selected>', false);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_and_service_routes_render_server_side(): void
    {
        foreach (['/', '/services', '/work', '/about', '/contact', '/blog', '/privacy'] as $url) {
            $this->get($url)->assertOk()->assertSee('<h1', false)->assertSee('rel="canonical"', false);
        }

        foreach (['web-development', 'website-repair', 'website-maintenance', 'web-applications'] as $slug) {
            $this->get("/services/{$slug}")->assertOk();
        }
    }

    public function test_unknown_slugs_return_404(): void
    {
        $this->get('/services/seo-magic')->assertNotFound();
        $this->get('/work/anything')->assertNotFound();
        $this->get('/blog/missing')->assertNotFound();
        $this->get('/no-such-page')->assertNotFound();
    }

    public function test_canonical_uses_app_url_not_request_host(): void
    {
        config(['app.url' => 'https://tretalab.com']);

        $this->get('http://evil.test/about')
            ->assertSee('<link rel="canonical" href="https://tretalab.com/about">', false);
    }

    public function test_blog_shows_only_live_posts(): void
    {
        $live = Post::factory()->published()->for(Category::factory())->create(['title' => 'Live post']);
        Post::factory()->create(['title' => 'Draft post', 'slug' => 'draft-post']);
        Post::factory()->scheduled()->create(['title' => 'Future post', 'slug' => 'future-post']);

        $this->get('/blog')->assertOk()->assertSee('Live post')->assertDontSee('Draft post')->assertDontSee('Future post');
        $this->get("/blog/{$live->slug}")->assertOk()->assertSee('Live post')
            ->assertSee('"@type":"BlogPosting"', false)
            ->assertSee('content="index,follow"', false);
        $this->get('/blog/draft-post')->assertNotFound();
        $this->get('/blog/future-post')->assertNotFound();
    }

    public function test_article_body_is_sanitized_and_overrides_apply(): void
    {
        $post = Post::factory()->published()->create([
            'content' => '<p>Body</p><script>alert(1)</script>',
            'robots' => 'noindex,follow',
            'canonical_url' => 'https://example.org/original',
            'seo_title' => 'Custom <b>title</b>',
        ]);

        $this->get("/blog/{$post->slug}")
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('content="noindex,follow"', false)
            ->assertSee('href="https://example.org/original"', false)
            ->assertSee('Custom &lt;b&gt;title&lt;/b&gt;', false);
    }

    public function test_preview_is_staff_only_and_never_indexable(): void
    {
        $draft = Post::factory()->create(['title' => 'Secret draft']);

        $this->get("/admin/preview/posts/{$draft->id}")->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create())
            ->get("/admin/preview/posts/{$draft->id}")
            ->assertOk()
            ->assertSee('Secret draft')
            ->assertSee('content="noindex,nofollow"', false)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_sitemap_lists_only_canonical_live_urls(): void
    {
        config(['app.url' => 'https://tretalab.com']);
        $live = Post::factory()->published()->create();
        $draft = Post::factory()->create();
        $future = Post::factory()->scheduled()->create();
        $noindex = Post::factory()->published()->create(['robots' => 'noindex,nofollow']);
        $elsewhere = Post::factory()->published()->create(['canonical_url' => 'https://example.org/x']);

        $xml = $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->getContent();

        $this->assertStringContainsString('<loc>https://tretalab.com/</loc>', $xml);
        $this->assertStringContainsString('<loc>https://tretalab.com/blog</loc>', $xml);
        $this->assertStringContainsString("<loc>https://tretalab.com/blog/{$live->slug}</loc>", $xml);

        foreach ([$draft, $future, $noindex, $elsewhere] as $hidden) {
            $this->assertStringNotContainsString("/blog/{$hidden->slug}<", $xml);
        }

        // Services with approved SEO copy are listed; no enabled projects, privacy unapproved, no admin.
        foreach (array_keys(config('services.offerings')) as $slug) {
            $this->assertStringContainsString("<loc>https://tretalab.com/services/{$slug}</loc>", $xml);
        }
        $this->assertStringNotContainsString('/work/', $xml);
        $this->assertStringNotContainsString('/privacy', $xml);
        $this->assertStringNotContainsString('/admin', $xml);

        $this->assertNotFalse(simplexml_load_string($xml));
    }

    public function test_service_without_approved_seo_copy_stays_out_of_the_sitemap(): void
    {
        config(['services.offerings.website-repair.meta_description' => null]);

        $this->get('/sitemap.xml')
            ->assertDontSee('/services/website-repair</loc>', false)
            ->assertSee('/services/web-development</loc>', false);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Providers\AppServiceProvider;
use App\Support\Redirects;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** View contracts, SEO payloads, structured data, redirects, robots, analytics and headers. */
class SiteContractTest extends TestCase
{
    use RefreshDatabase;

    private function jsonLd(string $html): array
    {
        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $this->assertNotEmpty($m, 'no JSON-LD block');

        return json_decode($m[1], true, flags: JSON_THROW_ON_ERROR);
    }

    // ---- View contract -------------------------------------------------------------------------

    public function test_contact_form_has_hidden_honeypot_and_limits_matching_validation(): void
    {
        $html = $this->get('/contact')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('#<div aria-hidden="true"[^>]*>.*?name="website"[^>]*tabindex="-1"[^>]*autocomplete="off"#s', $html);
        $this->assertStringContainsString('name="name" value="" autocomplete="name" maxlength="100"', $html);
        $this->assertStringContainsString('maxlength="150"', $html);
        $this->assertStringContainsString('maxlength="5000"', $html);
    }

    public function test_article_with_featured_image_renders_dimensions_and_no_crash_for_drafts(): void
    {
        Storage::fake('public');
        Storage::disk('public')->putFileAs('posts', UploadedFile::fake()->image('a.png', 640, 360), 'a.png');
        $post = Post::factory()->published()->create(['featured_image_path' => 'posts/a.png', 'featured_image_alt' => 'Alt text']);

        $this->get("/blog/{$post->slug}")->assertOk()
            ->assertSee('width="640" height="360"', false)->assertSee('alt="Alt text"', false)
            ->assertDontSee('Preview — not published');

        $draft = Post::factory()->create(['featured_image_path' => 'posts/missing.png']);
        $this->actingAs(User::factory()->create())->get("/admin/preview/posts/{$draft->id}")
            ->assertOk()->assertSee('Preview — not published')->assertDontSee('<img', false);
    }

    public function test_blog_pagination_renders_project_markup(): void
    {
        Post::factory()->published()->count(13)->create();

        $this->get('/blog')->assertOk()
            ->assertSee('aria-label="Pagination"', false)->assertSee('rel="next"', false)
            ->assertDontSee('Showing');
        $this->get('/blog?page=2')->assertOk()->assertSee('rel="prev"', false);
    }

    // ---- SEO payloads --------------------------------------------------------------------------

    public function test_pages_use_approved_titles_and_default_description(): void
    {
        $titles = [
            '/' => 'TRETA Lab — Fix. Build. Care.',
            '/services' => 'Services — TRETA Lab',
            '/work' => 'Selected work — TRETA Lab',
            '/about' => 'About the studio — TRETA Lab',
            '/contact' => 'Start a conversation — TRETA Lab',
            '/blog' => 'The journal — TRETA Lab',
            '/privacy' => 'Privacy information — TRETA Lab',
        ];

        foreach ($titles as $url => $title) {
            $this->get($url)->assertOk()->assertSee("<title>{$title}</title>", false);
        }

        $this->get('/')->assertSee('content="'.e(config('seo.descriptions.home')).'"', false);
        $this->get('/services/website-repair')
            ->assertSee('<title>'.e(config('services.offerings.website-repair.seo_title')).'</title>', false)
            ->assertSee('content="'.e(config('services.offerings.website-repair.meta_description')).'"', false);
    }

    public function test_not_found_has_real_status_title_and_noindex(): void
    {
        foreach (['/nope', '/blog/missing', '/services/missing'] as $url) {
            $this->get($url)->assertNotFound()
                ->assertSee('<title>Page not found — TRETA Lab</title>', false)
                ->assertSee('content="noindex,follow"', false);
        }
    }

    // ---- Structured data -----------------------------------------------------------------------

    public function test_home_has_organization_and_website_with_only_known_facts(): void
    {
        config(['app.url' => 'https://tretalab.com', 'app.name' => 'TRETA Lab']);
        $graph = $this->jsonLd($this->get('/')->getContent())['@graph'];

        $this->assertSame(['Organization', 'WebSite'], array_column($graph, '@type'));
        $this->assertSame('TRETA Lab', $graph[0]['name']);
        $this->assertSame('https://tretalab.com/', $graph[0]['url']);
        $this->assertEqualsCanonicalizing(['@type', '@id', 'name', 'url'], array_keys($graph[0]));
        foreach (['logo', 'sameAs', 'address', 'telephone', 'email', 'contactPoint'] as $invented) {
            $this->assertArrayNotHasKey($invented, $graph[0]);
        }
    }

    public function test_service_page_has_service_with_provider_and_breadcrumbs(): void
    {
        config(['app.url' => 'https://tretalab.com']);
        $graph = $this->jsonLd($this->get('/services/web-development')->getContent())['@graph'];

        $this->assertSame(['Service', 'BreadcrumbList'], array_column($graph, '@type'));
        $this->assertSame('Organization', $graph[0]['provider']['@type']);
        $this->assertSame('https://tretalab.com/services/web-development', $graph[0]['url']);
        $this->assertSame(['Home', 'Services', 'Web development'], array_column($graph[1]['itemListElement'], 'name'));
    }

    public function test_article_has_blogposting_and_breadcrumbs_and_json_is_html_safe(): void
    {
        $post = Post::factory()->published()->create(['title' => 'A "quoted" </script><b> title', 'excerpt' => "It's & fine"]);
        $html = $this->get("/blog/{$post->slug}")->assertOk()->getContent();

        $graph = $this->jsonLd($html)['@graph'];
        $this->assertSame(['BlogPosting', 'BreadcrumbList'], array_column($graph, '@type'));
        $this->assertSame($post->title, $graph[0]['headline']);
        $this->assertSame(3, count($graph[1]['itemListElement']));
        // Exactly one closing script tag inside the head block: the title cannot break out of the JSON.
        $this->assertSame(1, substr_count(explode('</head>', $html)[0], '</script>'));
    }

    // ---- Redirects -----------------------------------------------------------------------------

    public function test_redirect_validation_drops_loops_chains_and_off_site_targets(): void
    {
        $valid = Redirects::valid([
            '/old' => '/services',
            '/a' => '/b',
            '/b' => '/c',          // /a chains into /b: dropped; /b stays
            '/loop' => '/loop',
            '/x' => '/y',
            '/y' => '/x',          // mutual loop: both dropped
            '/evil' => 'https://evil.test',
            '/evil2' => '//evil.test/x',
            '/evil3' => '/\\evil.test',
            '/{param}' => '/home',
            'no-slash' => '/services',
        ]);

        $this->assertSame(['/old' => '/services', '/b' => '/c'], $valid);
    }

    public function test_empty_redirect_config_by_default(): void
    {
        $this->assertSame([], config('redirects'));
    }

    public function test_changed_slug_of_a_live_post_redirects_permanently(): void
    {
        $post = Post::factory()->published()->create(['slug' => 'first']);
        $draft = Post::factory()->create(['slug' => 'draft-old']);

        $post->update(['slug' => 'second']);
        $draft->update(['slug' => 'draft-new']);

        $this->get('/blog/first')->assertStatus(301)->assertRedirect('/blog/second');
        $this->get('/blog/second')->assertOk();
        $this->get('/blog/draft-old')->assertNotFound();   // drafts never had a public URL

        // Renaming back removes the stale redirect instead of looping.
        $post->update(['slug' => 'first']);
        $this->get('/blog/first')->assertOk();
        $this->get('/blog/second')->assertStatus(301)->assertRedirect('/blog/first');
    }

    public function test_old_slug_does_not_redirect_to_an_unpublished_post(): void
    {
        $post = Post::factory()->published()->create(['slug' => 'first']);
        $post->update(['slug' => 'second']);
        $post->update(['status' => 'draft']);

        $this->get('/blog/first')->assertNotFound();
    }

    // ---- robots.txt ----------------------------------------------------------------------------

    public function test_robots_is_closed_outside_production(): void
    {
        $this->get('/robots.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /', false)->assertDontSee('Sitemap:', false);
    }

    public function test_robots_in_production_allows_site_blocks_admin_and_lists_sitemap(): void
    {
        config(['app.url' => 'https://tretalab.com']);
        $this->app['env'] = 'production';

        $body = $this->get('/robots.txt')->assertOk()->getContent();

        $this->assertStringContainsString("Disallow: /admin\n", $body);
        $this->assertStringNotContainsString("Disallow: /\n", $body);
        $this->assertStringContainsString('Sitemap: https://tretalab.com/sitemap.xml', $body);
        $this->assertFileDoesNotExist(public_path('robots.txt'));
    }

    // ---- GA4 / Search Console ------------------------------------------------------------------

    public function test_analytics_is_off_without_id_or_outside_production(): void
    {
        $this->get('/')->assertDontSee('googletagmanager', false)->assertDontSee('google-site-verification', false);

        config(['seo.ga4_measurement_id' => 'G-TEST1234']);   // id set, env still "testing"
        $this->get('/')->assertDontSee('googletagmanager', false);

        $this->app['env'] = 'production';                      // production but no id
        config(['seo.ga4_measurement_id' => null]);
        $this->get('/')->assertDontSee('googletagmanager', false);
    }

    public function test_analytics_renders_in_production_with_id_but_never_on_preview_and_ignores_bad_ids(): void
    {
        $this->app['env'] = 'production';
        config(['seo.ga4_measurement_id' => 'G-TEST1234', 'seo.google_site_verification' => 'verif-token']);

        $this->get('/')->assertSee('https://www.googletagmanager.com/gtag/js?id=G-TEST1234', false)
            ->assertSee('<meta name="google-site-verification" content="verif-token">', false);

        $draft = Post::factory()->create();
        $this->actingAs(User::factory()->create())->get("/admin/preview/posts/{$draft->id}")
            ->assertOk()->assertDontSee('googletagmanager', false);

        config(['seo.ga4_measurement_id' => "G-X');alert(1);//"]);
        $this->get('/')->assertDontSee('googletagmanager', false);
    }

    // ---- Security headers & proxies ------------------------------------------------------------

    public function test_security_headers_are_sent_and_hsts_only_for_secure_production(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Permissions-Policy')
            ->assertHeaderMissing('Strict-Transport-Security');

        $this->app['env'] = 'production';
        $this->get('http://localhost/')->assertHeaderMissing('Strict-Transport-Security');
        $this->get('https://localhost/')->assertHeader('Strict-Transport-Security');
    }

    public function test_forwarded_ip_is_ignored_unless_proxy_is_trusted(): void
    {
        $this->assertNull(config('trustedproxy.proxies'));
        Route::middleware('web')->get('/_ip', fn () => request()->ip());

        $get = fn () => $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.1'])
            ->get('/_ip', ['X-Forwarded-For' => '203.0.113.9'])->getContent();

        // Untrusted by default: a spoofed header cannot dodge the rate limit.
        $this->assertSame('10.0.0.1', $get());

        config(['trustedproxy.proxies' => '10.0.0.1']);
        $this->assertSame('203.0.113.9', $get());
    }

    public function test_redirects_cannot_shadow_application_paths(): void
    {
        $valid = Redirects::valid([
            '/contact' => '/about', '/admin/login' => '/', '/admin' => '/', '/livewire/update' => '/', '/up' => '/',
            '/storage/x.png' => '/', '/build/app.js' => '/', '/sitemap.xml' => '/', '/robots.txt' => '/', '/blog' => '/', '/ADMIN/x' => '/',
            '/old-page' => '/services', '/blog/old-slug' => '/blog/new-slug',
        ]);

        $this->assertSame(['/old-page' => '/services', '/blog/old-slug' => '/blog/new-slug'], $valid);
    }

    public function test_page_descriptions_are_unique_and_short(): void
    {
        $seen = [];
        foreach (['/', '/services', '/work', '/about', '/contact', '/blog', '/privacy', '/nope'] as $url) {
            $html = $this->get($url)->getContent();
            preg_match('#<meta name="description" content="([^"]*)"#', $html, $m);
            $desc = html_entity_decode($m[1]);

            $this->assertNotEmpty($desc, $url);
            $this->assertLessThanOrEqual(165, mb_strlen($desc), $url);
            $this->assertNotContains($desc, $seen, "duplicate description on {$url}");
            $seen[] = $desc;
        }
    }

    public function test_blog_pagination_seo(): void
    {
        config(['app.url' => 'https://tretalab.com']);
        Post::factory()->published()->count(13)->create();

        $this->get('/blog')->assertSee('<link rel="canonical" href="https://tretalab.com/blog">', false)
            ->assertSee('<title>The journal — TRETA Lab</title>', false);

        $page2 = $this->get('/blog?page=2')->assertOk()
            ->assertSee('<link rel="canonical" href="https://tretalab.com/blog?page=2">', false)
            ->assertSee('<title>The journal — TRETA Lab — Page 2</title>', false)
            ->assertDontSee('?page=1', false);
        $page2->assertSee('href="'.route('blog.index').'"', false);

        $this->get('/blog?page=3')->assertNotFound();
        $this->get('/blog?page=999')->assertNotFound();
    }

    public function test_not_found_page_has_no_canonical(): void
    {
        $this->get('/some/missing/path')->assertNotFound()
            ->assertDontSee('rel="canonical"', false)->assertDontSee('og:url', false)->assertDontSee('/some/missing/path', false);
    }

    public function test_twitter_card_follows_og_image(): void
    {
        $this->get('/')->assertSee('<meta name="twitter:card" content="summary">', false);

        Storage::fake('public');
        $post = Post::factory()->published()->create(['social_image_path' => 'posts/s.png']);
        $this->get("/blog/{$post->slug}")->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('property="og:image"', false);
    }

    public function test_sitemap_does_not_load_article_bodies(): void
    {
        Post::factory()->published()->create(['content' => '<p>SECRETBODY</p>']);
        $queries = [];
        DB::listen(function ($q) use (&$queries) {
            $queries[] = str_replace('`', '"', $q->sql); // MySQL quotes identifiers with backticks
        });

        $this->get('/sitemap.xml')->assertOk();

        $posts = array_values(array_filter($queries, fn ($s) => str_contains($s, 'from "posts"')));
        $this->assertNotEmpty($posts);
        foreach ($posts as $sql) {
            $this->assertStringNotContainsString('"content"', $sql);
            $this->assertStringNotContainsString('*', $sql);
        }
    }

    public function test_app_url_problem_is_reported_only_in_production(): void
    {
        $problem = fn (string $url, string $env) => (function () use ($url, $env) {
            config(['app.url' => $url]);
            $this->app['env'] = $env;

            return AppServiceProvider::appUrlProblem();
        })();

        $this->assertNull($problem('http://localhost', 'testing'));
        $this->assertNotNull($problem('http://localhost', 'production'));
        $this->assertNotNull($problem('http://tretalab.com', 'production'));
        $this->assertNotNull($problem('https://127.0.0.1', 'production'));
        $this->assertNull($problem('https://tretalab.com', 'production'));
    }
}

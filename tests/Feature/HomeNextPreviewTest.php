<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeNextPreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_next_preview_does_not_exist_outside_local_env(): void
    {
        // The route is registered only when APP_ENV=local; the testing environment must 404.
        $this->get('/home-next')->assertNotFound();
        $this->assertFalse(app('router')->has('home.next'));
    }

    public function test_sitemap_never_lists_the_preview(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertDontSee('home-next');
    }

    public function test_preview_controller_is_noindex_with_header(): void
    {
        $response = app(PageController::class)->homeNext();

        $this->assertSame('noindex, nofollow', $response->headers->get('X-Robots-Tag'));
        $this->assertStringContainsString('<meta name="robots" content="noindex,nofollow">', $response->getContent());
        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }
}

<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeNextBuildTest extends TestCase
{
    use RefreshDatabase;

    private function page(): string
    {
        return app(PageController::class)->homeNext()->getContent();
    }

    public function test_hero_notes_link_to_real_service_routes(): void
    {
        $html = $this->page();

        foreach (['website-repair', 'web-development', 'website-maintenance'] as $slug) {
            $url = route('services.show', $slug);
            $this->assertStringContainsString('href="'.$url.'"', $html);
            $this->get($url)->assertOk();
        }
        $this->assertStringContainsString('href="'.route('contact.show').'"', $html);
        $this->assertStringContainsString('href="#process"', $html);
        $this->assertStringContainsString('Based in Nepal', $html);
    }

    public function test_no_invented_figures_dead_links_or_unverified_claims_remain(): void
    {
        $html = $this->page();

        foreach (['99.98%', '4.2s', 'Avg. reply', 'Mar 4', 'Apr 12', 'v2.4.1', '12 issues', 'Last backup', 'See the work', 'href="#work"', 'Learn more', 'senior', 'Three ways we help', 'Good work deserves'] as $needle) {
            $this->assertStringNotContainsString($needle, $html, $needle);
        }
        $this->assertSame(3, substr_count($html, 'Sample interface'));
        $this->assertSame(1, substr_count($html, '<h1'));
    }

    public function test_faq_renders_approved_entries_and_hides_placeholders_in_production(): void
    {
        $html = $this->page();

        $this->assertSame(count(array_filter(config('faq.home'), fn ($i) => isset($i['q']))), substr_count($html, '<details'));
        $this->assertStringContainsString('Who will I be talking to?', $html);
        $this->assertStringNotContainsString('Content needed', $html);
        $this->assertStringNotContainsString('>Questions<', $html);
    }

    public function test_faq_and_other_placeholders_appear_locally_only(): void
    {
        $this->app['env'] = 'local';
        $html = $this->page();

        $this->assertStringContainsString('Content needed: FAQ: how pricing works', $html);
        $this->assertStringContainsString('Content needed: hero art slot', $html);
        $this->assertStringContainsString('Content needed: team: photos', $html);
    }

    public function test_work_band_is_absent_in_production_while_config_is_empty(): void
    {
        config(['trust' => ['testimonials' => [], 'logos' => [], 'projects' => []]]);

        $html = $this->page();

        $this->assertStringNotContainsString('id="work"', $html);
        $this->assertStringNotContainsString('Selected work', $html);

        $this->app['env'] = 'local';
        $local = $this->page();
        $this->assertStringContainsString('id="work"', $local);
        $this->assertStringContainsString('Content needed: work band', $local);
    }

    public function test_work_band_renders_real_projects_in_every_environment(): void
    {
        config(['trust' => ['testimonials' => [], 'logos' => [], 'projects' => [
            ['title' => 'A real project', 'summary' => 'What changed.', 'href' => '/work', 'image' => '/images/x.webp', 'image_width' => 960, 'image_height' => 600, 'image_alt' => 'Screenshot'],
        ]]]);

        $html = $this->page();

        $this->assertStringContainsString('id="work"', $html);
        $this->assertStringContainsString('A real project', $html);
        $this->assertStringContainsString('width="960" height="600"', $html);
        $this->assertStringNotContainsString('Content needed', $html);
    }

    public function test_live_homepage_is_untouched_by_the_preview_assets(): void
    {
        $live = $this->get('/')->assertOk()->getContent();

        $this->assertStringNotContainsString('class="hn"', $live);
        $this->assertStringNotContainsString('hx-', $live);
        $this->assertStringContainsString('Have something that needs', $live);
    }
}

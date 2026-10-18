<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class FaqTrustTest extends TestCase
{
    use RefreshDatabase;

    public function test_faq_renders_configured_answers_as_native_details_and_hides_placeholders(): void
    {
        config(['faq.demo' => [
            ['q' => 'Why this?', 'a' => 'Because approved.'],
            ['placeholder' => 'FAQ: pricing (owner)'],
        ]]);

        $html = Blade::render('<x-inner.faq group="demo" />');

        $this->assertStringContainsString('<details', $html);
        $this->assertStringContainsString('Why this?', $html);
        $this->assertStringContainsString('Because approved.', $html);
        $this->assertStringNotContainsString('Content needed', $html);
    }

    public function test_faq_placeholder_entries_only_render_locally_and_empty_faq_renders_nothing(): void
    {
        config(['faq.only_placeholder' => [['placeholder' => 'FAQ: pricing (owner)']]]);
        $this->assertSame('', trim(Blade::render('<x-inner.faq group="only_placeholder" />')));
        $this->assertSame('', trim(Blade::render('<x-inner.faq group="missing.group" />')));

        $this->app['env'] = 'local';
        $this->assertStringContainsString('Content needed: FAQ: pricing (owner)', Blade::render('<x-inner.faq group="only_placeholder" />'));
    }

    public function test_every_shipped_faq_entry_is_well_formed_and_service_pages_use_them(): void
    {
        foreach (array_merge([config('faq.home')], config('faq.services')) as $items) {
            foreach ($items as $item) {
                $this->assertTrue(isset($item['placeholder']) || (filled($item['q'] ?? null) && filled($item['a'] ?? null)));
            }
        }

        $this->get('/services/website-repair')->assertOk()->assertSee('<details', false)->assertSee('What if a rebuild makes more sense?')->assertDontSee('Content needed');
        $this->get('/home-next')->assertNotFound();
    }

    public function test_trust_section_is_absent_outside_local_when_config_is_empty(): void
    {
        config(['trust' => ['testimonials' => [], 'logos' => [], 'projects' => []]]);

        $this->assertSame('', trim(Blade::render('<x-inner.trust />')));
        foreach (['/about', '/services'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('Clients and projects')->assertDontSee('Content needed');
        }
    }

    public function test_trust_placeholders_render_locally_and_real_config_renders_everywhere(): void
    {
        config(['trust' => ['testimonials' => [], 'logos' => [], 'projects' => []]]);
        $this->app['env'] = 'local';
        $this->assertStringContainsString('Content needed: testimonials', Blade::render('<x-inner.trust />'));

        $this->app['env'] = 'testing';
        config(['trust' => [
            'testimonials' => [['quote' => 'Approved words.', 'name' => 'A. Person', 'role' => 'Owner', 'company' => 'Example Co']],
            'logos' => [['name' => 'Example Co', 'src' => '/images/clients/example.svg', 'width' => 120, 'height' => 40]],
            'projects' => [['title' => 'A project', 'summary' => 'What changed.', 'href' => '/work']],
        ]]);
        $html = Blade::render('<x-inner.trust />');

        $this->assertStringContainsString('Approved words.', $html);
        $this->assertStringContainsString('width="120" height="40"', $html);
        $this->assertStringContainsString('A project', $html);
        $this->assertStringNotContainsString('Content needed', $html);
    }

    public function test_engagement_terms_placeholders_are_local_only_and_footer_variant_is_opt_in(): void
    {
        $this->assertStringNotContainsString('Content needed', Blade::render('<x-inner.engagement />'));
        $this->assertStringContainsString('Three ways we help.', Blade::render('<x-inner.engagement />'));

        $this->get('/services')->assertOk()->assertSee('How we work together');
        $this->get('/')->assertOk()->assertDontSee('on-footer-next', false);
        $this->get('/about')->assertOk()->assertSee('on-footer-next', false);
    }

    public function test_icons_are_decorative_by_default_and_engagement_ships_default_art(): void
    {
        $this->assertStringContainsString('aria-hidden="true"', Blade::render('<x-inner.icon name="fix" />'));
        $this->assertStringContainsString('aria-label="Mail"', Blade::render('<x-inner.icon name="mail" title="Mail" />'));

        $html = Blade::render('<x-inner.engagement />');
        $this->assertSame(3, substr_count($html, 'viewBox="0 0 200 96"'));
        $custom = Blade::render('<x-inner.engagement :art="$art" />', ['art' => ['project' => '<svg data-custom="1"></svg>']]);
        $this->assertStringContainsString('data-custom="1"', $custom);
        $this->assertSame(2, substr_count($custom, 'viewBox="0 0 200 96"'));
    }
}

<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeNextBuildTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_next_renders_the_same_sections_as_the_live_homepage(): void
    {
        $next = app(PageController::class)->homeNext()->getContent();
        $live = $this->get('/')->assertOk()->getContent();

        foreach (['id="problems"', 'id="services"', 'id="process"', 'id="about"', 'Have something that needs'] as $needle) {
            $this->assertStringContainsString($needle, $next);
            $this->assertStringContainsString($needle, $live);
        }
    }

    public function test_polished_home_keeps_one_nav_target_per_label(): void
    {
        $live = $this->get('/')->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/href="#process"[^>]*>Explore our approach/', $live);
        $this->assertStringContainsString('All work →', $live);
        $this->assertStringNotContainsString('hx-', $live);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogJournalTest extends TestCase
{
    use RefreshDatabase;

    private function words(int $n): string
    {
        return '<p>'.implode(' ', array_fill(0, $n, 'word')).'</p>';
    }

    public function test_reading_time_is_whole_minutes_at_220_wpm_with_a_minimum_of_one(): void
    {
        $this->assertSame(1, Post::factory()->make(['content' => ''])->reading_time);
        $this->assertSame(1, Post::factory()->make(['content' => $this->words(220)])->reading_time);
        $this->assertSame(2, Post::factory()->make(['content' => $this->words(221)])->reading_time);
        $this->assertSame(5, Post::factory()->make(['content' => '<h2>Head</h2>'.$this->words(1000)])->reading_time);
    }

    public function test_related_posts_prefer_the_same_category_and_exclude_current_drafts_and_scheduled(): void
    {
        $news = Category::factory()->create();
        $other = Category::factory()->create();
        $current = Post::factory()->published()->create(['category_id' => $news->id]);
        Post::factory()->published()->create(['category_id' => $news->id, 'published_at' => now()->subDays(30), 'title' => 'Same category old']);
        Post::factory()->published()->create(['category_id' => $other->id, 'published_at' => now()->subHour(), 'title' => 'Other category new']);
        Post::factory()->create(['category_id' => $news->id, 'title' => 'Hidden draft']);
        Post::factory()->scheduled()->create(['category_id' => $news->id, 'title' => 'Hidden scheduled']);

        $this->get("/blog/{$current->slug}")->assertOk()
            ->assertSeeInOrder(['Keep reading', 'Same category old', 'Other category new'])
            ->assertDontSee('Hidden draft')->assertDontSee('Hidden scheduled');
    }

    public function test_related_posts_are_capped_at_three_and_hidden_when_there_are_none(): void
    {
        $category = Category::factory()->create();
        $current = Post::factory()->published()->create(['category_id' => $category->id]);

        $this->get("/blog/{$current->slug}")->assertOk()->assertDontSee('Keep reading');

        Post::factory()->published()->count(5)->create(['category_id' => $category->id]);
        $html = $this->get("/blog/{$current->slug}")->assertOk()->assertSee('Keep reading')->getContent();
        $this->assertSame(3, substr_count($html, 'data-related-post'));
    }

    public function test_category_filter_lists_only_categories_with_live_posts_and_noindexes_the_filtered_view(): void
    {
        $live = Category::factory()->create(['name' => 'Live cat', 'slug' => 'live-cat']);
        $empty = Category::factory()->create(['name' => 'Draft only cat', 'slug' => 'draft-only']);
        Post::factory()->published()->create(['category_id' => $live->id, 'title' => 'In live cat']);
        Post::factory()->published()->create(['title' => 'Uncategorised post']);
        Post::factory()->create(['category_id' => $empty->id, 'title' => 'Draft in empty cat']);

        $this->get('/blog')->assertOk()
            ->assertSee('Live cat')->assertDontSee('Draft only cat')
            ->assertSee('content="index,follow"', false);

        $this->get('/blog?category=live-cat')->assertOk()
            ->assertSee('In live cat')->assertDontSee('Uncategorised post')
            ->assertSee('content="noindex,follow"', false)
            ->assertSee('<link rel="canonical" href="'.url('/blog').'">', false);

        $this->get('/blog?category=draft-only')->assertNotFound();
        $this->get('/blog?category=nope')->assertNotFound();
        $this->get('/blog?category[]=live-cat')->assertNotFound();
    }

    public function test_pagination_keeps_the_category_query(): void
    {
        $category = Category::factory()->create(['slug' => 'many']);
        Post::factory()->published()->count(13)->create(['category_id' => $category->id]);

        $this->get('/blog?category=many')->assertOk()->assertSee('category=many&amp;page=2', false);
        $this->get('/blog?category=many&page=2')->assertOk()
            ->assertSee('rel="prev"', false)->assertSee('href="'.url('/blog').'?category=many"', false);
    }
}

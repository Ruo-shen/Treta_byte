<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostDomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_published_posts_whose_time_has_arrived_are_public(): void
    {
        $live = Post::factory()->published()->create();
        $draft = Post::factory()->create();
        $scheduled = Post::factory()->scheduled()->create();
        $unpublished = Post::factory()->published()->create();
        $unpublished->update(['status' => PostStatus::Draft]);

        $this->assertEquals([$live->id], Post::published()->pluck('id')->all());
        $this->assertTrue($live->isPublic());
        $this->assertFalse($draft->isPublic());
        $this->assertFalse($scheduled->isPublic());
        $this->assertFalse($unpublished->fresh()->isPublic());
    }

    public function test_scheduled_post_becomes_public_when_its_time_arrives(): void
    {
        $post = Post::factory()->scheduled()->create();

        $this->travel(2)->days();

        $this->assertTrue($post->fresh()->isPublic());
        $this->assertSame(1, Post::published()->count());
    }

    public function test_publishing_without_a_date_stamps_now(): void
    {
        $post = Post::factory()->create();
        $post->update(['status' => PostStatus::Published]);

        $this->assertNotNull($post->published_at);
        $this->assertTrue($post->isPublic());
    }

    public function test_slug_is_generated_and_must_be_unique(): void
    {
        $post = Post::factory()->create(['title' => 'Hello World', 'slug' => null]);
        $this->assertSame('hello-world', $post->slug);

        $this->expectException(QueryException::class);
        Post::factory()->create(['slug' => 'hello-world']);
    }

    public function test_unknown_robots_value_is_dropped(): void
    {
        $post = Post::factory()->create(['robots' => 'index,follow" onload="x']);
        $this->assertNull($post->robots);

        $post->update(['robots' => 'noindex,follow']);
        $this->assertSame('noindex,follow', $post->robots);
    }

    public function test_relationships(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->for($category)->create();

        $this->assertTrue($post->category->is($category));
        $this->assertTrue($category->posts->first()->is($post));
        $this->assertTrue($post->author->posts->first()->is($post));

        $category->delete();
        $this->assertNull($post->fresh()->category_id);
    }

    public function test_rendered_content_is_sanitized(): void
    {
        $post = Post::factory()->create([
            'content' => '<p>Safe</p><script>alert(1)</script><a href="javascript:alert(1)">x</a><img src=x onerror="alert(1)">',
        ]);

        $html = $post->contentHtml();

        $this->assertStringContainsString('Safe', $html);
        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('onerror', $html);
    }

    public function test_inquiry_defaults_to_new_status(): void
    {
        $inquiry = Inquiry::factory()->create();

        $this->assertSame(InquiryStatus::New, $inquiry->fresh()->status);
        $this->assertNull($inquiry->notified_at);
    }
}

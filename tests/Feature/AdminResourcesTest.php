<?php

namespace Tests\Feature;

use App\Enums\InquiryStatus;
use App\Enums\PostStatus;
use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminResourcesTest extends TestCase
{
    use RefreshDatabase;

    private User $staff;

    protected function setUp(): void
    {
        parent::setUp();
        $this->staff = User::factory()->create();
    }

    public function test_guests_cannot_reach_any_resource_page(): void
    {
        $post = Post::factory()->create();
        $inquiry = Inquiry::factory()->create();

        foreach (['/admin/posts', '/admin/posts/create', "/admin/posts/{$post->id}/edit", '/admin/categories', '/admin/inquiries', "/admin/inquiries/{$inquiry->id}/edit"] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
    }

    public function test_staff_can_open_resource_pages(): void
    {
        $this->actingAs($this->staff);
        $post = Post::factory()->create();
        $inquiry = Inquiry::factory()->create();

        foreach (['/admin/posts', '/admin/posts/create', "/admin/posts/{$post->id}/edit", '/admin/categories', '/admin/inquiries', "/admin/inquiries/{$inquiry->id}/edit"] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_inquiries_cannot_be_created_or_deleted_in_admin(): void
    {
        $this->actingAs($this->staff)->get('/admin/inquiries/create')->assertNotFound();

        Livewire::test(ListInquiries::class)->assertActionDoesNotExist('create');
        Livewire::test(EditInquiry::class, ['record' => Inquiry::factory()->create()->getRouteKey()])
            ->assertActionDoesNotExist('delete');
    }

    public function test_staff_can_create_a_draft_post_owned_by_them(): void
    {
        $this->actingAs($this->staff);
        $category = Category::factory()->create();

        Livewire::test(CreatePost::class)
            ->fillForm([
                'title' => 'First article',
                'slug' => 'first-article',
                'category_id' => $category->id,
                'excerpt' => 'Short',
                'status' => PostStatus::Draft->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $post = Post::firstWhere('slug', 'first-article');
        $this->assertTrue($post->author->is($this->staff));
        $this->assertSame(PostStatus::Draft, $post->status);
        $this->assertFalse($post->isPublic());
    }

    public function test_duplicate_or_malformed_slug_is_rejected_with_a_message(): void
    {
        $this->actingAs($this->staff);
        Post::factory()->create(['slug' => 'taken']);

        Livewire::test(CreatePost::class)
            ->fillForm(['title' => 'X', 'slug' => 'taken', 'status' => 'draft'])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'unique']);

        Livewire::test(CreatePost::class)
            ->fillForm(['title' => 'X', 'slug' => 'Bad Slug!', 'status' => 'draft'])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'regex']);

        Category::factory()->create(['slug' => 'news']);
        Livewire::test(CreateCategory::class)
            ->fillForm(['name' => 'News', 'slug' => 'news'])
            ->call('create')
            ->assertHasFormErrors(['slug' => 'unique']);
    }

    public function test_publish_and_unpublish_actions(): void
    {
        $this->actingAs($this->staff);
        $post = Post::factory()->create();

        Livewire::test(ListPosts::class)->callTableAction('publish', $post);
        $this->assertTrue($post->fresh()->isPublic());

        Livewire::test(ListPosts::class)->callTableAction('unpublish', $post);
        $this->assertSame(PostStatus::Draft, $post->fresh()->status);
        $this->assertFalse($post->fresh()->isPublic());
    }

    public function test_featured_image_requires_alt_text_and_accepts_only_raster_images(): void
    {
        $this->actingAs($this->staff);
        Storage::fake('public');
        $post = Post::factory()->create();

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['featured_image_path' => UploadedFile::fake()->image('cover.png'), 'featured_image_alt' => null])
            ->call('save')
            ->assertHasFormErrors(['featured_image_alt']);

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['featured_image_path' => UploadedFile::fake()->createWithContent('x.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>')])
            ->call('save')
            ->assertHasFormErrors(['featured_image_path']);

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['featured_image_path' => UploadedFile::fake()->create('shell.php.png', 10, 'application/x-php')])
            ->call('save')
            ->assertHasFormErrors(['featured_image_path']);

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['featured_image_path' => UploadedFile::fake()->image('big.jpg')->size(5000), 'featured_image_alt' => 'Alt'])
            ->call('save')
            ->assertHasFormErrors(['featured_image_path']);

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['featured_image_path' => UploadedFile::fake()->image('cover.jpg', 1200, 630), 'featured_image_alt' => 'A cover'])
            ->call('save')
            ->assertHasNoFormErrors();

        $path = $post->fresh()->featured_image_path;
        $this->assertStringStartsWith('posts/', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_canonical_override_must_be_http_url(): void
    {
        $this->actingAs($this->staff);
        $post = Post::factory()->create();

        Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
            ->fillForm(['canonical_url' => 'javascript:alert(1)'])
            ->call('save')
            ->assertHasFormErrors(['canonical_url']);
    }

    public function test_inquiry_edit_changes_only_status_and_notes(): void
    {
        $this->actingAs($this->staff);
        $inquiry = Inquiry::factory()->create(['name' => 'Original', 'message' => 'Original message text']);

        Livewire::test(EditInquiry::class, ['record' => $inquiry->getRouteKey()])
            ->fillForm(['name' => 'Changed', 'message' => 'Changed', 'status' => InquiryStatus::Replied->value, 'internal_notes' => 'Called back'])
            ->call('save')
            ->assertHasNoFormErrors();

        $inquiry->refresh();
        $this->assertSame('Original', $inquiry->name);
        $this->assertSame('Original message text', $inquiry->message);
        $this->assertSame(InquiryStatus::Replied, $inquiry->status);
        $this->assertSame('Called back', $inquiry->internal_notes);
    }
}

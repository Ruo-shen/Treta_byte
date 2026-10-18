<?php

namespace App\Models;

use App\Enums\PostStatus;
use Database\Factories\PostFactory;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    public const ROBOTS_OPTIONS = [
        'index,follow' => 'index, follow',
        'noindex,follow' => 'noindex, follow',
        'noindex,nofollow' => 'noindex, nofollow',
    ];

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'featured_image_alt',
        'status',
        'published_at',
        'seo_title',
        'meta_description',
        'social_image_path',
        'canonical_url',
        'robots',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->status === PostStatus::Published && $post->published_at === null) {
                $post->published_at = now();
            }

            if (! array_key_exists((string) $post->robots, self::ROBOTS_OPTIONS)) {
                $post->robots = null;
            }
        });

        // A live post whose slug changes keeps answering at its old URL (301 to the new one).
        static::updated(function (Post $post) {
            if (! $post->wasChanged('slug')) {
                return;
            }

            DB::table('post_slug_redirects')->where('old_slug', $post->slug)->delete();

            if ($post->getOriginal('status') === PostStatus::Published && $post->getOriginal('published_at') !== null) {
                DB::table('post_slug_redirects')->updateOrInsert(
                    ['old_slug' => $post->getOriginal('slug')],
                    ['post_id' => $post->id, 'created_at' => now(), 'updated_at' => now()],
                );
            }
        });

        // Replaced or removed images must not linger as public files.
        static::updated(function (Post $post) {
            foreach (self::IMAGE_COLUMNS as $column) {
                if ($post->wasChanged($column) && filled($old = $post->getOriginal($column))) {
                    Storage::disk('public')->delete($old);
                }
            }
        });

        static::deleted(function (Post $post) {
            Storage::disk('public')->delete(array_filter($post->only(self::IMAGE_COLUMNS)));
        });
    }

    private const IMAGE_COLUMNS = ['featured_image_path', 'social_image_path'];

    /** Publicly visible: published and its publication time has arrived. */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('status', PostStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublic(): bool
    {
        return $this->status === PostStatus::Published
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }

    /** Sanitized HTML for Blade: render with {!! $post->contentHtml() !!}. */
    public function contentHtml(): string
    {
        return blank($this->content) ? '' : RichContentRenderer::make($this->content)->toHtml();
    }

    /** Featured image for Blade: url plus intrinsic size from the public-disk file, or null when absent or unreadable. */
    public function featuredImage(): ?array
    {
        $path = $this->featured_image_path;
        $disk = Storage::disk('public');

        if (blank($path) || ! $disk->exists($path) || ! $size = @getimagesize($disk->path($path))) {
            return null;
        }

        return ['url' => $disk->url($path), 'width' => $size[0], 'height' => $size[1]];
    }

    /** Whole minutes to read the article at ~220 words per minute (minimum 1): $post->reading_time. */
    protected function readingTime(): Attribute
    {
        return Attribute::get(function (): int {
            $words = preg_split('/\s+/u', trim(strip_tags($this->contentHtml())), -1, PREG_SPLIT_NO_EMPTY);

            return max(1, (int) ceil(count($words) / 220));
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

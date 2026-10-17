<?php

namespace App\Models;

use App\Enums\PostStatus;
use Database\Factories\PostFactory;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    }

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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

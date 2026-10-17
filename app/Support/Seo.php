<?php

namespace App\Support;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

/** Builds the $seo array consumed by the public layout (docs/ARCHITECTURE.md §6). */
class Seo
{
    /**
     * @param  array<string, mixed>  $extra  robots, og_image, type, json_ld
     * @return array{title: string, description: string, canonical: string, robots: string, og_image: ?string, type: string, json_ld: ?array}
     */
    public static function make(string $title, ?string $description = null, ?string $path = null, array $extra = []): array
    {
        return [
            'title' => $title,
            'description' => $description ?: config('seo.default_description'),
            'canonical' => self::absolute($path ?? request()->path()),
            'robots' => $extra['robots'] ?? 'index,follow',
            'og_image' => $extra['og_image'] ?? null,
            'type' => $extra['type'] ?? 'website',
            'json_ld' => $extra['json_ld'] ?? null,
        ];
    }

    public static function forRoute(string $name, array $params, string $title, ?string $description = null, array $extra = []): array
    {
        return self::make($title, $description, route($name, $params, false), $extra);
    }

    public static function forPost(Post $post, bool $preview = false): array
    {
        $canonical = self::absolute(route('blog.show', $post->slug, false));
        $image = $post->social_image_path ?: $post->featured_image_path;
        $ogImage = $image ? self::absolute(Storage::disk('public')->url($image)) : null;
        $description = $post->meta_description ?: $post->excerpt;

        return [
            ...self::make($post->seo_title ?: $post->title, $description, null, [
                'type' => 'article',
                'og_image' => $ogImage,
                'robots' => $preview ? 'noindex,nofollow' : ($post->robots ?: 'index,follow'),
                'json_ld' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'headline' => $post->title,
                    'description' => $description,
                    'datePublished' => $post->published_at?->toAtomString(),
                    'dateModified' => $post->updated_at?->toAtomString(),
                    'mainEntityOfPage' => $canonical,
                    'image' => $ogImage,
                    'publisher' => ['@type' => 'Organization', 'name' => config('app.name')],
                ],
            ]),
            'canonical' => self::isHttpUrl($post->canonical_url) ? $post->canonical_url : $canonical,
        ];
    }

    /** Canonical URLs come from APP_URL, never from the request Host header. */
    public static function absolute(string $pathOrUrl): string
    {
        if (self::isHttpUrl($pathOrUrl)) {
            $pathOrUrl = parse_url($pathOrUrl, PHP_URL_PATH) ?? '/';
        }

        $path = '/'.ltrim($pathOrUrl, '/');

        return rtrim((string) config('app.url'), '/').($path === '/' ? '/' : rtrim($path, '/'));
    }

    public static function isHttpUrl(?string $url): bool
    {
        return is_string($url)
            && filter_var($url, FILTER_VALIDATE_URL) !== false
            && in_array(strtolower((string) parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true);
    }
}

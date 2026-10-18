<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Seo;
use Illuminate\Http\Response;
use XMLWriter;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = new XMLWriter;
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->urls() as [$loc, $lastmod]) {
            $xml->startElement('url');
            $xml->writeElement('loc', $loc);
            if ($lastmod) {
                $xml->writeElement('lastmod', $lastmod);
            }
            $xml->endElement();
        }

        $xml->endElement();

        return response($xml->outputMemory(), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /** @return list<array{0: string, 1: ?string}> */
    private function urls(): array
    {
        $urls = [];

        foreach (config('seo.sitemap_static_routes') as $name) {
            $urls[] = [Seo::absolute(route($name, [], false)), null];
        }

        // Service pages enter only once their approved SEO copy exists.
        foreach (config('services.offerings') as $slug => $service) {
            if (filled($service['seo_title']) && filled($service['meta_description'])) {
                $urls[] = [Seo::absolute(route('services.show', $slug, false)), null];
            }
        }

        foreach (array_keys(WorkController::enabledProjects()) as $slug) {
            $urls[] = [Seo::absolute(route('work.show', $slug, false)), null];
        }

        // Only live, indexable posts that are their own canonical.
        Post::published()
            ->select(['id', 'slug', 'title', 'seo_title', 'meta_description', 'excerpt', 'robots', 'canonical_url', 'social_image_path', 'featured_image_path', 'published_at', 'updated_at'])
            ->latest('published_at')->get()
            ->reject(fn (Post $post) => str_starts_with((string) $post->robots, 'noindex'))
            ->each(function (Post $post) use (&$urls) {
                $seo = Seo::forPost($post);
                $own = Seo::absolute(route('blog.show', $post->slug, false));
                if ($seo['canonical'] === $own) {
                    $urls[] = [$own, $post->updated_at->toAtomString()];
                }
            });

        return $urls;
    }
}

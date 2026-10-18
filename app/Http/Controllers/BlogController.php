<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\Seo;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        // ?category=<slug> filters to one category that has live posts; anything else is a 404.
        $slug = $request->query('category');
        $category = null;
        if ($request->query->has('category')) {
            $category = is_string($slug)
                ? Category::where('slug', $slug)->whereHas('posts', fn ($q) => $q->published())->first()
                : null;
            abort_if($category === null, 404);
        }

        $posts = Post::published()->with('category')
            ->when($category, fn ($q) => $q->where('category_id', $category->id))
            ->latest('published_at')->paginate(12)->withQueryString();
        $page = $posts->currentPage();

        // Pages past the end are not real pages.
        abort_if($page > 1 && $posts->isEmpty(), 404);

        // Page 1 is /blog; later pages are self-canonical with their own title.
        // A filtered view is a thin duplicate of the journal: canonical stays /blog and it is kept out of the index.
        $seo = Seo::forPage('blog', $page > 1 && ! $category ? "/blog?page={$page}" : '/blog', $category ? ['robots' => 'noindex,follow'] : []);
        if ($category) {
            $seo['title'] .= " — {$category->name}";
        }
        if ($page > 1) {
            $seo['title'] .= " — Page {$page}";
        }

        return view('blog.index', [
            'seo' => $seo,
            'posts' => $posts,
            'activeCategory' => $category,
            'categories' => Category::whereHas('posts', fn ($q) => $q->published())->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $post = Post::published()->with('category')->where('slug', $slug)->first();

        if (! $post) {
            return $this->movedSlug($slug) ?? abort(404);
        }

        return view('blog.show', $this->data($post, preview: false));
    }

    /** Staff-only preview of any post, including drafts and scheduled posts. Never indexable or cacheable. */
    public function preview(Request $request, Post $post): Response
    {
        abort_unless($request->user()?->canAccessPanel(Filament::getPanel('admin')), 403);

        return response()
            ->view('blog.show', $this->data($post->load('category'), preview: true))
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'private, no-store');
    }

    /** @return array<string, mixed> the blog.show view contract */
    private function data(Post $post, bool $preview): array
    {
        return [
            'seo' => Seo::forPost($post, $preview),
            'post' => $post,
            'preview' => $preview,
            'contentHtml' => $post->contentHtml(),
            'featuredImage' => $post->featuredImage(),
            'related' => $preview ? new Collection : $this->related($post), // staff previews stay focused on the draft itself
        ];
    }

    /** Up to three other live posts: same category first, then the latest of the rest. Never drafts or scheduled posts. */
    private function related(Post $post): Collection
    {
        $others = fn () => Post::published()->with('category')->whereKeyNot($post->id)->latest('published_at');

        $same = $post->category_id ? $others()->where('category_id', $post->category_id)->limit(3)->get() : new Collection;

        return $same->count() >= 3
            ? $same
            : $same->concat($others()->whereNotIn('id', $same->modelKeys())->limit(3 - $same->count())->get());
    }

    /** 301 from the old slug of a post whose slug was changed, if that post is live now. */
    private function movedSlug(string $slug): ?RedirectResponse
    {
        $postId = DB::table('post_slug_redirects')->where('old_slug', $slug)->value('post_id');
        $current = $postId ? Post::published()->find($postId) : null;

        return $current ? redirect()->route('blog.show', $current->slug, 301) : null;
    }
}

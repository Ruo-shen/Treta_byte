<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\Seo;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()->with('category')->latest('published_at')->paginate(12);
        $page = $posts->currentPage();

        // Pages past the end are not real pages.
        abort_if($page > 1 && $posts->isEmpty(), 404);

        // Page 1 is /blog; later pages are self-canonical with their own title.
        $seo = Seo::forPage('blog', $page > 1 ? "/blog?page={$page}" : '/blog');
        if ($page > 1) {
            $seo['title'] .= " — Page {$page}";
        }

        return view('blog.index', [
            'seo' => $seo,
            'posts' => $posts,
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
        ];
    }

    /** 301 from the old slug of a post whose slug was changed, if that post is live now. */
    private function movedSlug(string $slug): ?RedirectResponse
    {
        $postId = DB::table('post_slug_redirects')->where('old_slug', $slug)->value('post_id');
        $current = $postId ? Post::published()->find($postId) : null;

        return $current ? redirect()->route('blog.show', $current->slug, 301) : null;
    }
}

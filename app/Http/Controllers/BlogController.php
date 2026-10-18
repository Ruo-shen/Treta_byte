<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Support\Seo;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('blog.index', [
            'seo' => Seo::make('Blog | '.config('app.name'), null, '/blog'),
            'posts' => Post::published()->with('category')->latest('published_at')->paginate(12),
            'categories' => Category::whereHas('posts', fn ($q) => $q->published())->orderBy('name')->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()->with('category')->where('slug', $slug)->firstOrFail();

        return view('blog.show', ['seo' => Seo::forPost($post), 'post' => $post, 'preview' => false]);
    }

    /** Staff-only preview of any post, including drafts and scheduled posts. Never indexable or cacheable. */
    public function preview(Request $request, Post $post): Response
    {
        abort_unless($request->user()?->canAccessPanel(Filament::getPanel('admin')), 403);

        return response()
            ->view('blog.show', ['seo' => Seo::forPost($post, preview: true), 'post' => $post->load('category'), 'preview' => true])
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'private, no-store');
    }
}

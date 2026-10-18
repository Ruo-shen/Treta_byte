<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WorkController;
use App\Support\Redirects;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Route;

// Moved URLs (config/redirects.php) come first so they win over any public route.
foreach (Redirects::valid(config('redirects', [])) as $from => $to) {
    // Same action Route::redirect() uses (cache-safe), but GET/HEAD only.
    Route::match(['GET', 'HEAD'], $from, RedirectController::class)->defaults('destination', $to)->defaults('status', 301);
}

// Public route contract: docs/ARCHITECTURE.md §4.
Route::get('/', [PageController::class, 'home'])->name('home');
if (app()->environment('local')) {
    Route::get('/home-next', [PageController::class, 'homeNext'])->name('home.next');
}
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{slug}', [WorkController::class, 'show'])->name('work.show');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

// Staff-only draft preview; guests are sent to the Filament login.
Route::get('/admin/preview/posts/{post}', [BlogController::class, 'preview'])->middleware('auth')->name('posts.preview');

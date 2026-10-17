<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

// Public route contract: docs/ARCHITECTURE.md §4.
Route::get('/', [PageController::class, 'home'])->name('home');
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

// Staff-only draft preview; guests are sent to the Filament login.
Route::get('/admin/preview/posts/{post}', [BlogController::class, 'preview'])->middleware('auth')->name('posts.preview');

<?php

namespace App\Providers;

use App\Http\Controllers\ContactController;
use App\Http\Requests\StoreInquiryRequest;
use App\Support\Seo;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Project pagination markup (resources/views/pagination/default.blade.php), not the framework's.
        Paginator::defaultView('pagination.default');

        // Real 404 status stays; the page just needs its own title and must not be indexed.
        View::composer('errors::404', fn ($view) => $view->with('seo', Seo::make(config('seo.titles.not_found'), null, null, ['robots' => 'noindex,follow'])));

        // Contact form: a few per minute and a daily cap per IP. Over the limit, the visitor is sent back
        // with their input and a normal validation error rather than a bare 429 page.
        RateLimiter::for('contact', function (Request $request) {
            $tooMany = fn () => redirect()->to(ContactController::sameSiteBack())
                ->withInput($request->except(StoreInquiryRequest::HONEYPOT))
                ->withErrors(['message' => 'Too many messages sent. Please try again later.']);

            return [
                Limit::perMinute(3)->by('contact-min:'.$request->ip())->response($tooMany),
                Limit::perDay(20)->by('contact-day:'.$request->ip())->response($tooMany),
            ];
        });
    }
}

<?php

namespace App\Providers;

use App\Http\Controllers\ContactController;
use App\Http\Requests\StoreInquiryRequest;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
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

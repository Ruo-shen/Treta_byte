<?php

namespace App\Http\Controllers;

use App\Enums\InquiryTopic;
use App\Support\Seo;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'seo' => Seo::home(),
            'services' => config('services.offerings'),
            'projects' => WorkController::enabledProjects(),
        ]);
    }

    /** Local-only preview of the next homepage (routes/web.php registers it only when APP_ENV=local). */
    public function homeNext(): Response
    {
        return response()->view('pages.home-next', [
            'seo' => array_merge(Seo::home(), ['robots' => 'noindex,nofollow']),
            'services' => config('services.offerings'),
            'projects' => WorkController::enabledProjects(),
        ])->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function about(): View
    {
        return view('pages.about', ['seo' => Seo::forPage('about', '/about')]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'seo' => Seo::forPage('contact', '/contact'),
            'topics' => collect(InquiryTopic::cases())->mapWithKeys(fn ($t) => [$t->value => $t->getLabel()])->all(),
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy', ['seo' => Seo::forPage('privacy', '/privacy')]);
    }
}

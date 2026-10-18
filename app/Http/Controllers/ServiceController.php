<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'seo' => Seo::forPage('services', '/services'),
            'services' => config('services.offerings'),
        ]);
    }

    public function show(string $slug): View
    {
        $service = config('services.offerings')[$slug] ?? abort(404);

        return view('pages.services.show', [
            'seo' => Seo::forService($slug, $service),
            'slug' => $slug,
            'service' => $service,
            'projects' => array_filter(WorkController::enabledProjects(), fn ($p) => ($p['service'] ?? null) === $slug),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        return view('pages.work.index', [
            'seo' => Seo::forPage('work', '/work'),
            'projects' => self::enabledProjects(),
        ]);
    }

    public function show(string $slug): View
    {
        $project = self::enabledProjects()[$slug] ?? abort(404);

        // Every approved project renders through the shared case-study template.
        return view('pages.work.case-study', [
            'seo' => Seo::make($project['seo_title'] ?? $project['title'], $project['meta_description'] ?? null),
            'slug' => $slug,
            'project' => $project,
        ]);
    }

    /** @return array<string, array<string, mixed>> approved projects keyed by slug */
    public static function enabledProjects(): array
    {
        return array_filter(config('work', []), fn ($p) => ($p['enabled'] ?? false) === true);
    }
}

<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    /** Production is crawlable (except /admin); every other environment is closed to crawlers. */
    public function __invoke(): Response
    {
        $body = app()->isProduction()
            ? "User-agent: *\nDisallow: /admin\n\nSitemap: ".Seo::absolute('/sitemap.xml')."\n"
            : "User-agent: *\nDisallow: /\n";

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}

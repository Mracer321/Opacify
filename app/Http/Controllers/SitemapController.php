<?php

namespace App\Http\Controllers;

use App\Support\Sitemap;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function show(Sitemap $sitemap): Response
    {
        return response()
            ->view('sitemap.xml', ['urls' => $sitemap->urls()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}

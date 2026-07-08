<?php

namespace App\Support;

use App\Models\Project;
use Illuminate\Support\Carbon;

class Sitemap
{
    /**
     * Technology slugs that 301 to canonical /hire-* pages — excluded to avoid duplicates.
     */
    private const REDIRECTED_TECHNOLOGY_SLUGS = ['laravel', 'react', 'nodejs', 'flutter'];

    /**
     * @return list<array{loc: string, lastmod: string|null}>
     */
    public function urls(): array
    {
        $urls = [];

        // Static pages are backed by Blade views; use the view file's modified
        // time as a stable lastmod so crawlers can schedule recrawls.
        foreach ([
            'home' => 'pages/home.blade.php',
            'services' => 'pages/services/index.blade.php',
            'about' => 'pages/about.blade.php',
            'contact' => 'pages/contact.blade.php',
            'privacy-policy' => 'pages/legal/privacy-policy.blade.php',
            'terms' => 'pages/legal/terms.blade.php',
            'blog.index' => 'pages/blog/index.blade.php',
            'case-studies.index' => 'pages/case-studies/index.blade.php',
            'landing.ads' => 'pages/landing/ads.blade.php',
        ] as $routeName => $view) {
            $urls[] = $this->entry($this->routeUrl($routeName), $this->viewDate($view));
        }

        foreach ([
            'hire-laravel-developers',
            'hire-react-developers',
            'hire-nodejs-developers',
            'hire-flutter-developers',
        ] as $path) {
            $urls[] = $this->entry($this->siteUrl($path), $this->viewDate('pages/'.$path.'.blade.php'));
        }

        $servicesDate = $this->fileDate(resource_path('data/services.php'));
        $services = require resource_path('data/services.php');
        foreach (array_keys($services) as $slug) {
            $urls[] = $this->entry($this->routeUrl('services.show', $slug), $servicesDate);
        }

        $technologiesDate = $this->fileDate(resource_path('data/technologies.php'));
        $technologies = require resource_path('data/technologies.php');
        foreach (array_keys($technologies) as $slug) {
            if (in_array($slug, self::REDIRECTED_TECHNOLOGY_SLUGS, true)) {
                continue;
            }
            $urls[] = $this->entry($this->routeUrl('technologies.show', $slug), $technologiesDate);
        }

        $blogPostsDate = $this->fileDate(resource_path('data/blog-posts.php'));
        $blogPosts = require resource_path('data/blog-posts.php');
        foreach (array_keys($blogPosts) as $slug) {
            $urls[] = $this->entry($this->siteUrl('blog/'.$slug), $blogPostsDate);
        }

        Project::query()
            ->published()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get(['slug', 'updated_at'])
            ->each(function (Project $project) use (&$urls): void {
                $urls[] = $this->entry(
                    $this->routeUrl('case-studies.show', $project->slug),
                    $project->updated_at,
                );
            });

        return $urls;
    }

    private function viewDate(string $relativeView): ?string
    {
        return $this->fileDate(resource_path('views/'.$relativeView));
    }

    /**
     * Stable Y-m-d lastmod derived from a source file's modified time.
     */
    private function fileDate(string $path): ?string
    {
        $timestamp = @filemtime($path);

        return $timestamp === false ? null : Carbon::createFromTimestamp($timestamp)->toDateString();
    }

    private function routeUrl(string $name, mixed $parameters = []): string
    {
        return $this->siteUrl(ltrim(route($name, $parameters, absolute: false), '/'));
    }

    private function siteUrl(string $path = ''): string
    {
        $base = rtrim((string) config('app.url'), '/');
        $path = ltrim($path, '/');

        return $path === '' ? $base : $base.'/'.$path;
    }

    /**
     * @return array{loc: string, lastmod: string|null}
     */
    private function entry(string $loc, Carbon|string|null $lastmod = null): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod instanceof Carbon ? $lastmod->toDateString() : $lastmod,
        ];
    }
}

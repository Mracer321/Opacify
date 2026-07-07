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

        foreach ([
            'home',
            'services',
            'about',
            'contact',
            'privacy-policy',
            'terms',
            'blog.index',
            'case-studies.index',
            'landing.ads',
        ] as $routeName) {
            $urls[] = $this->entry($this->routeUrl($routeName));
        }

        foreach ([
            'hire-laravel-developers',
            'hire-react-developers',
            'hire-nodejs-developers',
            'hire-flutter-developers',
        ] as $path) {
            $urls[] = $this->entry($this->siteUrl($path));
        }

        $services = require resource_path('data/services.php');
        foreach (array_keys($services) as $slug) {
            $urls[] = $this->entry($this->routeUrl('services.show', $slug));
        }

        $technologies = require resource_path('data/technologies.php');
        foreach (array_keys($technologies) as $slug) {
            if (in_array($slug, self::REDIRECTED_TECHNOLOGY_SLUGS, true)) {
                continue;
            }
            $urls[] = $this->entry($this->routeUrl('technologies.show', $slug));
        }

        $blogPosts = require resource_path('data/blog-posts.php');
        foreach (array_keys($blogPosts) as $slug) {
            $urls[] = $this->entry($this->siteUrl('blog/'.$slug));
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
    private function entry(string $loc, ?Carbon $lastmod = null): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod?->toDateString(),
        ];
    }
}

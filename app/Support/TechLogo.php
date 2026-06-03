<?php

namespace App\Support;

class TechLogo
{
    private static ?array $config = null;

    private static int $instanceCounter = 0;

    public static function config(): array
    {
        if (self::$config === null) {
            self::$config = require resource_path('data/tech-logos.php');
        }

        return self::$config;
    }

    public static function slugFor(string $name): ?string
    {
        $config = self::config();
        $aliases = $config['aliases'] ?? [];

        if (isset($aliases[$name])) {
            return $aliases[$name];
        }

        $normalized = strtolower(trim($name));
        $normalized = str_replace([' ', '.', '/'], ['', '', ''], $normalized);

        $map = [
            'nextjs' => 'nextdotjs',
            'nodejs' => 'nodedotjs',
            'reactjs' => 'react',
            'reactnative' => 'react',
            'vuejs' => 'vuedotjs',
            'aws' => 'amazonaws',
            'css3' => 'css',
            'tailwindcss' => 'tailwindcss',
            'springboot' => 'springboot',
            'aiml' => 'tensorflow',
            'restapis' => 'openapiinitiative',
            'cicd' => 'githubactions',
            'vpsclouddeployment' => 'digitalocean',
            'dataanalytics' => 'googleanalytics',
            'powerbi' => 'powerbi',
            'openaiapi' => 'openai',
            'googleanalytics' => 'googleanalytics',
        ];

        $slug = $map[$normalized] ?? $normalized;

        return isset($config['logos'][$slug]) ? $slug : null;
    }

    public static function logoFor(string $name): ?array
    {
        $slug = self::slugFor($name);

        if ($slug === null) {
            return null;
        }

        return self::config()['logos'][$slug] ?? null;
    }

    /**
     * Logo SVG with gradient/clip IDs scoped to this render instance.
     * Prevents duplicate id collisions when many tech icons appear on one page.
     */
    public static function scopedLogoFor(string $name): ?array
    {
        $logo = self::logoFor($name);

        if ($logo === null) {
            return null;
        }

        self::$instanceCounter++;
        $prefix = 'ti' . self::$instanceCounter;

        return [
            'viewBox' => $logo['viewBox'],
            'svg' => self::scopeSvgIds($logo['svg'], $prefix),
            'source' => $logo['source'],
        ];
    }

    private static function scopeSvgIds(string $svg, string $prefix): string
    {
        $scoped = preg_replace_callback(
            '/\bid="([^"]+)"/',
            static fn (array $matches): string => 'id="' . $prefix . '-' . $matches[1] . '"',
            $svg
        );

        $scoped = preg_replace_callback(
            '/url\(#([^)]+)\)/',
            static fn (array $matches): string => 'url(#' . $prefix . '-' . $matches[1] . ')',
            $scoped ?? $svg
        );

        return preg_replace_callback(
            '/href="#([^"]+)"/',
            static fn (array $matches): string => 'href="#' . $prefix . '-' . $matches[1] . '"',
            $scoped ?? $svg
        ) ?? $svg;
    }
}

<?php

namespace App\Support;

class TechLogo
{
    private static ?array $config = null;

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
}

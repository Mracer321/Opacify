<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRouteRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_major_existing_public_routes_remain_accessible(): void
    {
        foreach ([
            '/',
            '/contact',
            '/services',
            '/services/web-development',
            '/hire-laravel-developers',
            '/hire-react-developers',
            '/hire-nodejs-developers',
            '/hire-flutter-developers',
            '/lp/hire-developers',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_existing_dedicated_technology_redirects_still_work(): void
    {
        $this->get('/technologies/laravel')->assertRedirect('/hire-laravel-developers');
        $this->get('/technologies/react')->assertRedirect('/hire-react-developers');
        $this->get('/technologies/nodejs')->assertRedirect('/hire-nodejs-developers');
        $this->get('/technologies/flutter')->assertRedirect('/hire-flutter-developers');
    }
}

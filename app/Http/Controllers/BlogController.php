<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('pages.blog.index', [
            'posts' => array_values(require resource_path('data/blog-posts.php')),
        ]);
    }

    public function show(string $slug): View
    {
        $posts = require resource_path('data/blog-posts.php');

        if (! isset($posts[$slug])) {
            abort(404);
        }

        return view('pages.blog.show', [
            'post' => $posts[$slug],
        ]);
    }
}

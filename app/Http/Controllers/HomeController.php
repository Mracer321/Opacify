<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            // Up to 4 published projects flagged for the homepage, ordered by
            // sort_order ascending with a stable secondary order (id) for ties.
            'featuredProjects' => Project::query()
                ->published()
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(4)
                ->get(),
        ]);
    }
}

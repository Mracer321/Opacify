<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'featuredProject' => Project::query()
                ->published()
                ->where('is_featured', true)
                ->orderByDesc('id')
                ->first(),
        ]);
    }
}

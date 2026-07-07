<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(): View
    {
        return view('pages.case-studies.index', [
            'projects' => Project::query()
                ->published()
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $project = Project::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.case-studies.show', [
            'project' => $project,
        ]);
    }
}

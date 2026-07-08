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

        // Sibling case studies power the "Related case studies" block, giving
        // each deep page additional internal links (fixes the orphan finding).
        $relatedProjects = Project::query()
            ->published()
            ->whereKeyNot($project->getKey())
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        return view('pages.case-studies.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}

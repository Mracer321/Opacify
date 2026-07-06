<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TechnologyPageController extends Controller
{
    public function show(string $slug): View
    {
        // Allowlist lookup only — the slug is used solely as an array key, never to
        // resolve files/classes or query models. Unknown slugs are a hard 404.
        // Load in an isolated scope so the data file's internal variables cannot
        // leak into (and clobber) $slug via require's caller-scope semantics.
        $catalog = (static fn () => require resource_path('data/technologies.php'))();

        if (! isset($catalog[$slug])) {
            abort(404);
        }

        return view('pages.technology', [
            'technology' => $catalog[$slug],
        ]);
    }
}

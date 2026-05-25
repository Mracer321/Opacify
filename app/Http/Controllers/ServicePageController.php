<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePageController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index');
    }

    public function show(string $slug): View
    {
        $catalog = require resource_path('data/services.php');

        if (! isset($catalog[$slug])) {
            abort(404);
        }

        return view('pages.services.show', [
            'service' => $catalog[$slug],
        ]);
    }
}

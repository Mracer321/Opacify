@props([
    'title' => 'Project interface',
    'subtitle' => 'Dashboard & workflow preview',
    'variant' => 'dashboard',
])

<x-ui-mockup :variant="$variant" :title="$title" :subtitle="$subtitle" {{ $attributes }} />

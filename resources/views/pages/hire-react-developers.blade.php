@extends('layouts.app')

@section('title', 'Hire Expert React Developers — OpacifyWeb')
@section('meta_description', 'Hire React developers for SPAs, dashboards, and design systems. Senior frontend engineers, flexible engagement models.')
@section('canonical', 'https://opacifyweb.in/hire-react-developers')

@section('content')
    <x-technology-page :tech="[
        'name' => 'React',
        'slug' => 'react',
        'headline' => 'Hire Expert React Developers',
        'description' => 'Ship polished dashboards, customer portals, and design-system-driven UIs with React engineers who understand state, performance, and accessibility.',
        'rate' => '$20–$48/hour',
        'skills' => ['React 18+', 'TypeScript', 'Next.js', 'Redux / Zustand', 'TanStack Query', 'Storybook & testing'],
        'benefits' => [
            ['UI excellence', 'Engineers who partner with design and enforce component consistency.'],
            ['Performance focus', 'Code splitting, memoization, and Core Web Vitals awareness.'],
            ['Team integration', 'Comfortable in PR reviews, Figma handoffs, and CI pipelines.'],
        ],
        'longform' => 'Whether you maintain a Create React App legacy codebase or a Next.js 14 product, we match developers who have already solved your class of problems—data tables with virtualization, complex forms, or real-time updates via WebSockets.',
    ]" />
@endsection

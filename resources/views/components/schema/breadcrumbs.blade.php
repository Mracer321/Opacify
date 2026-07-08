@props(['items' => []])

{{--
    Emits BreadcrumbList JSON-LD into the global schema stack.
    items: ordered list of ['name' => string, 'url' => ?string].
    Omit 'url' on the final (current-page) crumb.
    JSON is assembled in PHP so the schema.org context/type keys are not
    parsed as Blade directives.
--}}
@php
    $schemaBreadcrumbs = json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn ($item, $i) => array_filter([
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'] ?? null,
            'item' => $item['url'] ?? null,
        ], fn ($v) => $v !== null))->all(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
@push('schema')
<script type="application/ld+json">{!! $schemaBreadcrumbs !!}</script>
@endpush

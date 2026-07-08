@props([
    'name',
    'description' => null,
    'serviceType' => null,
    'url' => null,
])

{{--
    Emits Service JSON-LD into the global schema stack.
    provider references the global Organization node (#org).
    JSON is assembled in PHP so the schema.org context/type keys are not
    parsed as Blade directives.
--}}
@php
    $schemaService = json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $name,
        'description' => $description,
        'serviceType' => $serviceType,
        'url' => $url,
        'provider' => ['@id' => 'https://opacify.in/#org'],
        'areaServed' => 'Worldwide',
    ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
@push('schema')
<script type="application/ld+json">{!! $schemaService !!}</script>
@endpush

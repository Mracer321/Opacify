@props(['post'])

{{--
    Emits BlogPosting JSON-LD (with an author Person for E-E-A-T) into the
    global schema stack. publisher references the Organization node.
    JSON is assembled in PHP so the schema.org context/type keys are not
    parsed as Blade directives.
--}}
@php
    $datePublished = rescue(
        fn () => \Illuminate\Support\Carbon::parse($post['date'])->toIso8601String(),
        null,
        false,
    );

    $schemaBlogPosting = json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post['title'],
        'description' => $post['excerpt'] ?? null,
        'datePublished' => $datePublished,
        'author' => array_filter([
            '@type' => 'Person',
            'name' => $post['author'] ?? null,
            'jobTitle' => $post['role'] ?? null,
        ], fn ($v) => $v !== null && $v !== ''),
        'publisher' => ['@id' => 'https://opacify.in/#org'],
        'mainEntityOfPage' => 'https://opacify.in/blog/'.$post['slug'],
        'image' => 'https://opacify.in/images/og-default.png',
    ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
@push('schema')
<script type="application/ld+json">{!! $schemaBlogPosting !!}</script>
@endpush

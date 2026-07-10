@props(['post'])

{{--
    Emits BlogPosting JSON-LD (with an author Person for E-E-A-T) into the
    global schema stack. publisher references the Organization node.
    JSON is assembled in PHP so the schema.org context/type keys are not
    parsed as Blade directives. Reads from the BlogPost model so structured
    data always matches the rendered post + SEO fallbacks.
--}}
@php
    $schemaBlogPosting = json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->effectiveMetaDescription(),
        'datePublished' => $post->publishedAtIso(),
        'dateModified' => optional($post->updated_at)->toIso8601String(),
        'author' => array_filter([
            '@type' => 'Person',
            'name' => $post->author,
            'jobTitle' => $post->author_role,
        ], fn ($v) => $v !== null && $v !== ''),
        'publisher' => ['@id' => 'https://opacify.in/#org'],
        'mainEntityOfPage' => $post->effectiveCanonical(),
        'image' => $post->effectiveOgImageUrl(),
    ], fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
@push('schema')
<script type="application/ld+json">{!! $schemaBlogPosting !!}</script>
@endpush

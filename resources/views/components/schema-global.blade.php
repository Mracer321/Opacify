{{--
    Global Organization + WebSite structured data (JSON-LD).
    Rendered in <head> on every page that uses layouts.app.

    "sameAs" lists the official, verified OpacifyWeb social profiles. Keep these
    in sync with the footer social links in components/footer.blade.php.

    NOTE: the JSON is assembled in PHP so Blade does not interpret the
    schema.org context/type keys as Blade directives.
--}}
@php
    $schemaGlobal = json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => 'https://opacify.in/#org',
                'name' => 'OpacifyWeb',
                'url' => 'https://opacify.in',
                'logo' => 'https://opacify.in/images/logo.png',
                'email' => 'opacifyweb@gmail.com',
                'telephone' => '+91-88020-32023',
                'sameAs' => [
                    'https://in.linkedin.com/company/opacifyweb',
                    'https://x.com/opacifyweb',
                    'https://www.instagram.com/opacifypvtltd/',
                ],
            ],
            [
                '@type' => 'WebSite',
                '@id' => 'https://opacify.in/#website',
                'url' => 'https://opacify.in',
                'name' => 'OpacifyWeb',
                'publisher' => ['@id' => 'https://opacify.in/#org'],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
@endphp
<script type="application/ld+json">{!! $schemaGlobal !!}</script>

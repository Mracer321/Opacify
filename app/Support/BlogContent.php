<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Renders inline text from block content into a SAFE, minimal HTML subset.
 *
 * Security model: the raw text is HTML-escaped FIRST, so no author input can
 * ever inject markup or scripts. Only a small whitelist is then applied on the
 * already-escaped string:
 *   - **bold**            -> <strong>
 *   - [label](url)        -> <a href="url"> for validated URLs only
 *
 * Everything else (including any literal HTML the author typed) stays escaped.
 */
class BlogContent
{
    /**
     * Convert a single line/paragraph of block text into safe inline HTML.
     */
    public static function inline(?string $text): string
    {
        $escaped = e((string) $text);

        // Links: [label](url) — label and url are already escaped.
        $escaped = preg_replace_callback(
            '/\[([^\]]+)\]\(([^)\s]+)\)/',
            static function (array $m): string {
                $label = $m[1];
                $url = $m[2];

                if (! self::isSafeUrl($url)) {
                    return $label; // Drop unsafe link, keep the text.
                }

                $external = Str::startsWith($url, ['http://', 'https://']);
                $rel = $external ? ' rel="noopener noreferrer" target="_blank"' : '';

                return '<a href="'.$url.'" class="text-brand-700 hover:text-brand-800 underline"'.$rel.'>'.$label.'</a>';
            },
            $escaped
        );

        // Bold: **text**
        $escaped = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $escaped);

        return $escaped;
    }

    /**
     * Only allow site-relative, anchor, mailto, tel, http and https targets.
     * (Values are already HTML-escaped, so "&amp;" etc. are fine.)
     */
    private static function isSafeUrl(string $url): bool
    {
        if (Str::startsWith($url, ['/', '#'])) {
            return true;
        }

        return Str::startsWith(Str::lower($url), ['http://', 'https://', 'mailto:', 'tel:']);
    }
}

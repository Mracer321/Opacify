<?php

namespace App\Support;

use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

/**
 * Renders block content into SAFE HTML.
 *
 * Two entry points:
 *   - render()  full block-level Markdown (paragraphs, lists, quotes, inline
 *               formatting). Used for free-text areas where an author may paste
 *               multi-paragraph content from an editor or an AI tool.
 *   - inline()  a minimal single-run subset for cells and list items, where a
 *               block-level <p>/<ul> wrapper would be invalid markup.
 *
 * Security model is the same for both: no author HTML is ever trusted. render()
 * runs CommonMark with html_input=escape and unsafe links disabled; inline()
 * HTML-escapes first and then applies a tiny whitelist on the escaped string.
 */
class BlogContent
{
    private static ?CommonMarkConverter $converter = null;

    /**
     * Convert a full block of Markdown into safe HTML, preserving the author's
     * paragraphs, blank lines, and single line breaks exactly as pasted.
     *
     * Blank lines separate <p> elements; single newlines become <br>, so text
     * copied from Markdown editors, ChatGPT, Claude, VS Code, Obsidian or
     * GitHub keeps its shape without the author re-pressing Enter.
     */
    public static function render(?string $text): string
    {
        $text = (string) $text;

        if (trim($text) === '') {
            return '';
        }

        if (self::$converter === null) {
            self::$converter = new CommonMarkConverter([
                // Never emit author-supplied HTML: literal markup is escaped,
                // so it can never become live nodes. No raw HTML, ever.
                'html_input' => 'escape',
                // Strip javascript:, data:, and similar hostile link targets.
                'allow_unsafe_links' => false,
                // Keep the single line breaks the author typed. Without this a
                // soft break renders as a space and pasted structure collapses.
                'renderer' => [
                    'soft_break' => "<br>\n",
                ],
            ]);
        }

        return self::$converter->convert($text)->getContent();
    }

    /**
     * Convert a single run of block text into safe inline HTML. Supports
     * **bold**, *italic* / _italic_, `code`, and [label](url) links, and keeps
     * any hard newlines as <br>. Use render() for multi-paragraph content.
     */
    public static function inline(?string $text): string
    {
        $escaped = e((string) $text);

        // Protect inline code spans so their contents are not re-parsed as
        // bold/italic/link syntax. Restored last.
        $codes = [];
        $escaped = preg_replace_callback(
            '/`([^`]+)`/',
            static function (array $m) use (&$codes): string {
                $key = "\0CODE".count($codes)."\0";
                $codes[$key] = '<code class="rounded bg-slate-100 px-1.5 py-0.5 text-[0.85em] text-slate-800">'.$m[1].'</code>';

                return $key;
            },
            $escaped
        );

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

        // Bold: **text** (consumed before single-star italic).
        $escaped = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $escaped);

        // Italic: *text* and _text_ on the remaining single delimiters.
        $escaped = preg_replace('/(?<!\*)\*(?!\*)([^*\n]+?)\*(?!\*)/', '<em>$1</em>', $escaped);
        $escaped = preg_replace('/(?<![\w])_([^_\n]+?)_(?![\w])/', '<em>$1</em>', $escaped);

        // Keep author line breaks (HTML, not XHTML — no self-closing slash).
        $escaped = nl2br($escaped, false);

        // Restore protected code spans.
        return strtr($escaped, $codes);
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

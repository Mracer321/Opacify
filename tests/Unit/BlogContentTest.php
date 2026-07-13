<?php

namespace Tests\Unit;

use App\Support\BlogContent;
use PHPUnit\Framework\TestCase;

class BlogContentTest extends TestCase
{
    /** The exact content from the paste-fidelity report. */
    private string $pasted = "**Landing Page / One-Page Website**\n\nA single scrolling page.\n\n**Business Website**\n\nUsually includes 5–10 pages.\n\n**Corporate Website**\n\nLarger multi-page websites.";

    public function test_render_preserves_paragraph_separation(): void
    {
        $html = BlogContent::render($this->pasted);

        // Each blank-line-separated block becomes its own paragraph.
        $this->assertSame(6, substr_count($html, '<p>'));
        $this->assertStringContainsString('<strong>Landing Page / One-Page Website</strong>', $html);
        $this->assertStringContainsString('<p>A single scrolling page.</p>', $html);
        $this->assertStringContainsString('Usually includes 5–10 pages.', $html);
    }

    public function test_render_keeps_single_line_breaks(): void
    {
        $html = BlogContent::render("Line one\nLine two");

        $this->assertStringContainsString('Line one<br>', $html);
        $this->assertStringContainsString('Line two', $html);
    }

    public function test_render_supports_core_markdown(): void
    {
        $html = BlogContent::render("*italic* and `code` and [Home](/home)\n\n- one\n- two\n\n> a quote");

        $this->assertStringContainsString('<em>italic</em>', $html);
        $this->assertStringContainsString('<code>code</code>', $html);
        $this->assertStringContainsString('href="/home"', $html);
        $this->assertStringContainsString('<ul>', $html);
        $this->assertStringContainsString('<li>one</li>', $html);
        $this->assertStringContainsString('<blockquote>', $html);
    }

    public function test_render_escapes_raw_html_and_blocks_unsafe_links(): void
    {
        $html = BlogContent::render("<script>alert(1)</script>\n\n[link](javascript:alert(1))");

        // Raw HTML is escaped, never emitted as live nodes.
        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        // A hostile scheme never reaches an href.
        $this->assertStringNotContainsString('href="javascript', $html);
    }

    public function test_render_empty_is_empty(): void
    {
        $this->assertSame('', BlogContent::render(''));
        $this->assertSame('', BlogContent::render(null));
        $this->assertSame('', BlogContent::render("   \n  "));
    }

    public function test_inline_still_supports_whitelist_and_breaks(): void
    {
        $html = BlogContent::inline("**bold** *em* `c` [Home](/home)\nnext");

        $this->assertStringContainsString('<strong>bold</strong>', $html);
        $this->assertStringContainsString('<em>em</em>', $html);
        $this->assertStringContainsString('<code', $html);
        $this->assertStringContainsString('href="/home"', $html);
        $this->assertStringContainsString('<br>', $html);
    }
}

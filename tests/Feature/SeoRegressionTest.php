<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoRegressionTest extends TestCase
{
    public function test_contact_page_has_primary_h1(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('<h1 class="heading-section text-navy text-balance">Tell us about your project</h1>', false);
    }

    public function test_faqs_path_redirects_to_home_faq_anchor(): void
    {
        $this->get('/faqs')->assertRedirect('/#faqs');
    }

    public function test_retired_case_study_slug_redirects_to_current_slug(): void
    {
        $this->get('/case-studies/digitiffin-food-ordering-platform')
            ->assertRedirect('/case-studies/digitiffin-meal-ordering-platform');
    }

    public function test_legal_pages_include_related_internal_links(): void
    {
        $this->get('/privacy-policy')
            ->assertOk()
            ->assertSee('href="/contact"', false)
            ->assertSee('href="/terms"', false);

        $this->get('/terms')
            ->assertOk()
            ->assertSee('href="/contact"', false)
            ->assertSee('href="/privacy-policy"', false);
    }

    public function test_landing_page_includes_contact_internal_link(): void
    {
        $this->get('/lp/hire-developers')
            ->assertOk()
            ->assertSee('href="/contact"', false);
    }
}

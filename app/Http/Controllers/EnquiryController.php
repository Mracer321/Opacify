<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Support\EnquiryOptions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class EnquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'country_code' => ['required', Rule::in(EnquiryOptions::supportedCountryCodes())],
            'phone' => ['required', 'string', 'max:40', 'regex:/^[0-9\s\-\(\)]+$/'],
            'company_name' => ['nullable', 'string', 'max:160'],
            'technology' => ['required', Rule::in(EnquiryOptions::technologies())],
            'budget_type' => ['required', Rule::in(EnquiryOptions::budgetTypes())],
            'project_description' => ['required', 'string', 'min:10', 'max:5000'],
            'source' => ['nullable', 'string', 'max:500'],
            'website' => ['prohibited'],
        ], [
            'phone.regex' => 'Enter a valid phone number using digits, spaces, hyphens, or parentheses.',
            'website.prohibited' => 'Your enquiry could not be submitted.',
        ]);

        $phone = preg_replace('/\D+/', '', $validated['phone']);

        if (strlen($phone) < 6 || strlen($phone) > 15) {
            return back()
                ->withErrors(['phone' => 'Enter a phone number between 6 and 15 digits.'])
                ->withInput();
        }

        try {
            Enquiry::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'country_code' => $validated['country_code'],
                'phone' => $phone,
                'company' => $validated['company_name'] ?? null,
                'technology' => $validated['technology'],
                'budget_type' => $validated['budget_type'],
                'project_description' => $validated['project_description'],
                'source' => $this->normalizeSource($validated['source'] ?? null),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('enquiry_error', 'We could not submit your enquiry right now. Please try again in a few minutes.');
        }

        return back()->with('enquiry_success', 'Thank you. Your enquiry has been received and we will respond within one business day.');
    }

    private function normalizeSource(?string $source): string
    {
        if (! is_string($source) || $source === '') {
            return 'unknown';
        }

        $parts = parse_url($source);

        if ($parts === false || isset($parts['scheme']) || isset($parts['host'])) {
            return 'unknown';
        }

        $path = $parts['path'] ?? '';

        if ($path === '' || ! str_starts_with($path, '/') || str_starts_with($path, '//')) {
            return 'unknown';
        }

        if (preg_match('/[\x00-\x1F\x7F]/', $path) === 1 || strlen($path) > 255) {
            return 'unknown';
        }

        return $path;
    }
}

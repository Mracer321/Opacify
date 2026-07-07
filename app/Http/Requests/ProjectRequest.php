<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Routes are already protected by the `auth` middleware group.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize + clean repeatable arrays BEFORE validation so that
     * completely empty rows are dropped and never persisted.
     */
    protected function prepareForValidation(): void
    {
        $technologies = collect(Arr::wrap($this->input('technologies', [])))
            ->map(fn ($t) => is_string($t) ? trim($t) : '')
            ->filter(fn ($t) => $t !== '')
            ->values()
            ->all();

        $highlights = collect(Arr::wrap($this->input('highlights', [])))
            ->map(fn ($h) => is_string($h) ? trim($h) : '')
            ->filter(fn ($h) => $h !== '')
            ->values()
            ->all();

        $keyResults = collect(Arr::wrap($this->input('key_results', [])))
            ->map(fn ($r) => [
                'value' => is_array($r) ? trim((string) ($r['value'] ?? '')) : '',
                'label' => is_array($r) ? trim((string) ($r['label'] ?? '')) : '',
            ])
            ->reject(fn ($r) => $r['value'] === '' && $r['label'] === '')
            ->values()
            ->all();

        $this->merge([
            'technologies' => $technologies,
            'highlights' => $highlights,
            'key_results' => $keyResults,
            'is_featured' => $this->boolean('is_featured'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'slug' => [
                'required',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('projects', 'slug')->ignore($this->route('project')),
            ],
            'project_label' => ['required', 'string', 'max:120'],
            'short_summary' => ['required', 'string', 'max:500'],
            'industry' => ['required', 'string', 'max:120'],
            'duration' => ['required', 'string', 'max:80'],

            'technologies' => ['required', 'array', 'min:1'],
            'technologies.*' => ['required', 'string', 'max:80'],

            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['required', 'string', 'max:160'],

            'challenge' => ['required', 'string', 'max:5000'],
            'solution' => ['required', 'string', 'max:5000'],
            'team_summary' => ['required', 'string', 'max:255'],

            // Optional. Completely empty rows are stripped in prepareForValidation();
            // any row that survives has content, so both parts are then required
            // to honour the {value,label} data contract.
            'key_results' => ['nullable', 'array'],
            'key_results.*.value' => ['required', 'string', 'max:60'],
            'key_results.*.label' => ['required', 'string', 'max:160'],

            'testimonial_quote' => ['nullable', 'string', 'max:1000'],
            'testimonial_name' => ['nullable', 'string', 'max:120'],
            'testimonial_role' => ['nullable', 'string', 'max:160'],

            'status' => ['required', Rule::in([Project::STATUS_DRAFT, Project::STATUS_PUBLISHED])],
            'is_featured' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:100000'],

            'seo_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:300'],

            'primary_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'secondary_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'technologies.min' => 'Add at least one technology.',
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Managed media lives in this directory on the public disk. Only files
     * under this prefix are ever deleted, so unrelated public assets are safe.
     */
    private const MEDIA_DIR = 'projects';

    private const IMAGE_FIELDS = ['primary_image', 'secondary_image', 'og_image'];

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->latest('updated_at')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'project' => new Project(),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $this->preparePayload($request->validated());

        foreach (self::IMAGE_FIELDS as $field) {
            $data[$field] = $request->hasFile($field)
                ? $request->file($field)->store(self::MEDIA_DIR, 'public')
                : null;
        }

        $project = Project::create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('status', "Project \"{$project->title}\" created.");
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $this->preparePayload($request->validated());

        $replaced = [];
        foreach (self::IMAGE_FIELDS as $field) {
            if ($request->hasFile($field)) {
                $replaced[$field] = $project->{$field};
                $data[$field] = $request->file($field)->store(self::MEDIA_DIR, 'public');
            } else {
                // Preserve the current image when no replacement is uploaded.
                unset($data[$field]);
            }
        }

        $project->update($data);

        // Delete replaced files only after the new paths are safely persisted.
        foreach ($replaced as $oldPath) {
            $this->deleteManagedFile($oldPath);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('status', "Project \"{$project->title}\" updated.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        foreach (self::IMAGE_FIELDS as $field) {
            $this->deleteManagedFile($project->{$field});
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Project deleted.');
    }

    /**
     * Shape validated data for persistence (highlights become {text} objects).
     */
    private function preparePayload(array $validated): array
    {
        $validated['highlights'] = array_map(
            fn (string $text) => ['text' => $text],
            $validated['highlights'] ?? []
        );

        return $validated;
    }

    /**
     * Delete a managed media file, but never anything outside the media dir.
     */
    private function deleteManagedFile(?string $path): void
    {
        if (is_string($path) && $path !== '' && str_starts_with($path, self::MEDIA_DIR.'/')) {
            Storage::disk('public')->delete($path);
        }
    }
}

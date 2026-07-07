@extends('layouts.admin')

@section('title', 'Projects — OpacifyWeb Admin')

@section('content')
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-navy">Projects</h1>
            <p class="mt-1 text-sm text-slate-500">Case studies shown on the public site. Most recently updated first.</p>
        </div>
        <a href="{{ route('admin.projects.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-700">
            <x-icon name="plus" class="h-4 w-4" />
            Add Project
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Label</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Featured</th>
                        <th class="px-4 py-3">Sort</th>
                        <th class="px-4 py-3">Updated</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($projects as $project)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-navy">{{ $project->title }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $project->project_label }}</td>
                            <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-slate-500">{{ $project->slug }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if($project->isPublished())
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">Published</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">Draft</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-semibold text-brand-700 ring-1 ring-brand-200">Featured</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $project->sort_order }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $project->updated_at?->format('M j, Y') }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="font-semibold text-brand-700 hover:text-brand-800">Edit</a>
                                    <form method="post" action="{{ route('admin.projects.destroy', $project) }}"
                                          onsubmit="return confirm('Delete “{{ addslashes($project->title) }}”? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-slate-500">
                                No projects yet. <a href="{{ route('admin.projects.create') }}" class="font-semibold text-brand-700 hover:text-brand-800">Add your first project</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>
@endsection

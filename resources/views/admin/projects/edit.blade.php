@extends('layouts.admin')

@section('title', 'Edit Project — OpacifyWeb Admin')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Back to projects</a>
        <h1 class="mt-3 font-display text-3xl font-semibold text-navy">Edit project</h1>
        <p class="mt-1 text-sm text-slate-500">{{ $project->title }}</p>
    </div>

    @include('admin.projects._form')
@endsection

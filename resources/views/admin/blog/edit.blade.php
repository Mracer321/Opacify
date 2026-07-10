@extends('layouts.admin')

@section('title', 'Edit Post — OpacifyWeb Admin')

@section('content')
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <a href="{{ route('admin.blog.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Back to blog</a>
            <h1 class="mt-3 font-display text-3xl font-semibold text-navy">Edit post</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $post->title }}</p>
        </div>
        <a href="{{ route('admin.blog.preview', $post) }}" target="_blank"
           class="mt-1 inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            <x-icon name="app-window" class="h-4 w-4" /> Preview
        </a>
    </div>

    @include('admin.blog._form')
@endsection

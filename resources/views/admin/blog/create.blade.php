@extends('layouts.admin')

@section('title', 'Add Post — OpacifyWeb Admin')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.blog.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Back to blog</a>
        <h1 class="mt-3 font-display text-3xl font-semibold text-navy">Add post</h1>
    </div>

    @include('admin.blog._form')
@endsection

@extends('layouts.admin')

@section('title', 'Admin Login — OpacifyWeb')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-card sm:p-8">
            <h1 class="font-display text-2xl font-semibold text-navy">Admin login</h1>
            <p class="mt-2 text-sm text-slate-500">Sign in to view submitted enquiries.</p>

            <form method="post" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="label-field">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="input-field">
                    @error('email')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="label-field">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="input-field">
                    @error('password')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <x-button type="submit" variant="primary" size="lg" class="w-full">Login</x-button>
            </form>
        </div>
    </div>
@endsection

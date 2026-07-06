@extends('layouts.admin')

@section('title', 'Enquiry Details — OpacifyWeb Admin')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.enquiries.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Back to enquiries</a>
        <h1 class="mt-3 font-display text-3xl font-semibold text-navy">Enquiry details</h1>
        <p class="mt-1 text-sm text-slate-500">Submitted {{ $enquiry->created_at->format('M j, Y g:i A') }}</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft lg:col-span-2">
            <h2 class="font-display text-lg font-semibold text-navy">Project Description</h2>
            <p class="mt-4 whitespace-pre-line leading-relaxed text-slate-700">{{ $enquiry->project_description }}</p>
        </section>

        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft">
            <h2 class="font-display text-lg font-semibold text-navy">Contact</h2>
            <dl class="mt-4 space-y-4 text-sm">
                <div>
                    <dt class="font-medium text-slate-500">Name</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Email</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->email }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Full phone</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->country_code }} {{ $enquiry->phone }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Company</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->company ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Technology Required</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->technology }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Budget Type</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->budget_type }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Source</dt>
                    <dd class="mt-1 break-words text-navy">{{ $enquiry->source }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-500">Submitted At</dt>
                    <dd class="mt-1 text-navy">{{ $enquiry->created_at->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>
        </aside>
    </div>
@endsection

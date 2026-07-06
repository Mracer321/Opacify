@extends('layouts.admin')

@section('title', 'Enquiries — OpacifyWeb Admin')

@section('content')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-navy">Enquiries</h1>
            <p class="mt-1 text-sm text-slate-500">Newest project enquiries first.</p>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Company</th>
                        <th class="px-4 py-3">Technology</th>
                        <th class="px-4 py-3">Budget Type</th>
                        <th class="px-4 py-3">Source</th>
                        <th class="px-4 py-3">Submitted At</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-navy">{{ $enquiry->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->email }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->country_code }} {{ $enquiry->phone }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->company ?: '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->technology }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->budget_type }}</td>
                            <td class="max-w-[12rem] truncate px-4 py-3">{{ $enquiry->source }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $enquiry->created_at->format('M j, Y g:i A') }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="font-semibold text-brand-700 hover:text-brand-800">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-10 text-center text-slate-500">No enquiries submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $enquiries->links() }}
    </div>
@endsection

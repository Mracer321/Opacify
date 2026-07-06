@props([
'id' => 'lead-form',
'compact' => false,
'slim' => false,
'showCompany' => true,
'submitLabel' => 'Request Free Quote',
])

@php
$countries = \App\Support\EnquiryOptions::countryCodes();
$budgetOptions = \App\Support\EnquiryOptions::budgetTypes();
$technologies = \App\Support\EnquiryOptions::technologies();
$selectedCountryCode = old('country_code', '+91');
// $selectedCountry = collect($countries)->firstWhere('code', $selectedCountryCode) ?? $countries[0];
$sourcePath = request()->getPathInfo();
@endphp

<form
    id="{{ $id }}"
    action="{{ route('enquiries.store') }}"
    method="post"
    class="{{ $slim ? 'form-slim space-y-3' : 'space-y-4' }} {{ ($compact || $slim) ? '' : 'rounded-2xl border border-slate-200/80 bg-white p-6 shadow-card sm:p-8' }}"
    x-data="{
    countryOpen: false,
    selectedCode: @js($selectedCountryCode),
    countries: @js($countries),
    selectCountry(c) {
        this.selectedCode = c.code;
        this.countryOpen = false;
    }
}"
    {{ $attributes }}>
    @csrf
    <input type="hidden" name="source" value="{{ $sourcePath }}">
    <div class="absolute left-[-9999px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
        <label for="{{ $id }}-website">Website</label>
        <input type="text" id="{{ $id }}-website" name="website" tabindex="-1" autocomplete="off">
    </div>

    @if(session('enquiry_success'))
    <div class="rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm font-medium text-brand-800">
        {{ session('enquiry_success') }}
    </div>
    @endif
    @if(session('enquiry_error'))
    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
        {{ session('enquiry_error') }}
    </div>
    @endif

    <div class="{{ $compact ? 'grid gap-4 sm:grid-cols-2' : 'grid gap-4 sm:grid-cols-2' }}">
        <div class="{{ $compact ? 'sm:col-span-1' : '' }}">
            <label for="{{ $id }}-name" class="label-field">Full Name <span class="text-red-500">*</span></label>
            <input type="text" id="{{ $id }}-name" name="full_name" value="{{ old('full_name') }}" required autocomplete="name" class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }}" placeholder="Your name">
            @error('full_name')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="{{ $id }}-email" class="label-field">Email <span class="text-red-500">*</span></label>
            <input type="email" id="{{ $id }}-email" name="email" value="{{ old('email') }}" required autocomplete="email" class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }}" placeholder="you@company.com">
            @error('email')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="{{ $id }}-phone" class="label-field">Phone Number <span class="text-red-500">*</span></label>
        <div class="flex gap-2">
            <div class="relative shrink-0">
                <button
                    type="button"
                    @click="countryOpen = !countryOpen"
                    class="flex {{ $slim ? 'h-[42px]' : 'h-[46px]' }} min-w-[7.5rem] items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-800 transition-colors hover:bg-slate-100"
                    aria-haspopup="listbox"
                    :aria-expanded="countryOpen">
                    <span x-text="selectedCode">+91</span>
                    <svg class="ml-auto h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <input type="hidden" name="country_code" x-model="selectedCode" value="+91">
                <ul
                    x-show="countryOpen"
                    x-cloak
                    @click.outside="countryOpen = false"
                    class="absolute left-0 top-full z-20 mt-1 max-h-48 w-64 overflow-y-auto rounded-lg border border-slate-200 bg-white py-1 shadow-card"
                    role="listbox">
                    <template x-for="(c, index) in countries" :key="`${c.code}-${c.name}-${index}`">
                        <li>
                            <button type="button" @click="selectCountry(c)" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                <span x-text="c.name" class="flex-1 text-slate-700"></span>
                                <span x-text="c.code" class="text-slate-400"></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
            <input type="tel" id="{{ $id }}-phone" name="phone" value="{{ old('phone') }}" required class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }} flex-1" placeholder="Phone number">
        </div>
        @error('country_code')
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
        @error('phone')
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if($showCompany)
    <div>
        <label for="{{ $id }}-company" class="label-field">Company Name</label>
        <input type="text" id="{{ $id }}-company" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }}" placeholder="Your company">
        @error('company_name')
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="{{ $id }}-tech" class="label-field">Technology Required <span class="text-red-500">*</span></label>
            <select id="{{ $id }}-tech" name="technology" required class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }}">
                <option value="">Select technology</option>
                @foreach($technologies as $tech)
                <option value="{{ $tech }}" @selected(old('technology')===$tech)>{{ $tech }}</option>
                @endforeach
            </select>
            @error('technology')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="{{ $id }}-budget" class="label-field">Budget Type <span class="text-red-500">*</span></label>
            <select id="{{ $id }}-budget" name="budget_type" required class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }}">
                <option value="">Select budget type</option>
                @foreach($budgetOptions as $option)
                <option value="{{ $option }}" @selected(old('budget_type')===$option)>{{ $option }}</option>
                @endforeach
            </select>
            @error('budget_type')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="{{ $id }}-description" class="label-field">Project Description <span class="text-red-500">*</span></label>
        <textarea id="{{ $id }}-description" name="project_description" required rows="{{ $slim ? 2 : ($compact ? 3 : 4) }}" class="{{ $slim ? 'input-field input-field-sm' : 'input-field' }} resize-y" placeholder="Briefly describe your project, timeline, and team needs">{{ old('project_description') }}</textarea>
        @error('project_description')
        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-1">
        <x-button type="submit" variant="primary" :size="$slim ? 'md' : 'lg'" class="w-full sm:w-auto">{{ $submitLabel }}</x-button>
        <p class="mt-3 text-xs text-slate-500">By submitting, you agree to our privacy policy. We respond within one business day.</p>
    </div>
</form>
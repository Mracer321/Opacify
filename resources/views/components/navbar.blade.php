@php
$servicesMenu = [
    ['label' => 'Web Development', 'href' => '/services/web-development', 'desc' => 'Scalable web apps and portals'],
    ['label' => 'Mobile App Development', 'href' => '/services/mobile-app-development', 'desc' => 'iOS, Android, and cross-platform'],
    ['label' => 'ERP Solutions', 'href' => '/services/erp-solutions', 'desc' => 'Business process automation'],
    ['label' => 'Software Development', 'href' => '/services/software-development', 'desc' => 'Custom enterprise software'],
    ['label' => 'Digital Marketing', 'href' => '/services/digital-marketing', 'desc' => 'Growth-focused campaigns'],
    ['label' => 'AI & Automation', 'href' => '/services/ai-automation', 'desc' => 'Intelligent workflows'],
];

$techMenu = [
    'Frontend Technologies' => [
        ['ReactJS', '/hire-react-developers'],
        ['Angular', '/technologies/angular'],
        ['Vue.js', '/technologies/vue'],
        ['HTML5', '/technologies/html5'],
        ['CSS3', '/technologies/css3'],
        ['JavaScript', '/technologies/javascript'],
        ['TypeScript', '/technologies/typescript'],
        ['TailwindCSS', '/technologies/tailwind'],
        ['Bootstrap', '/technologies/bootstrap'],
    ],
    'Backend Technologies' => [
        ['PHP', '/technologies/php'],
        ['Laravel', '/hire-laravel-developers'],
        ['Node.js', '/hire-nodejs-developers'],
        ['Python', '/technologies/python'],
        ['Spring Boot', '/technologies/spring-boot'],
        ['Java', '/technologies/java'],
        ['REST APIs', '/technologies/rest-apis'],
    ],
    'Mobile Technologies' => [
        ['Flutter', '/hire-flutter-developers'],
        ['React Native', '/technologies/react-native'],
        ['Android', '/technologies/android'],
        ['iOS', '/technologies/ios'],
    ],
    'Database Technologies' => [
        ['MySQL', '/technologies/mysql'],
        ['PostgreSQL', '/technologies/postgresql'],
        ['MongoDB', '/technologies/mongodb'],
        ['Firebase', '/technologies/firebase'],
    ],
    'Cloud & DevOps' => [
        ['Docker', '/technologies/docker'],
        ['Jenkins', '/technologies/jenkins'],
        ['GitHub', '/technologies/github'],
        ['CI/CD', '/technologies/cicd'],
        ['VPS & Cloud Deployment', '/technologies/cloud-deployment'],
    ],
    'AI & Analytics' => [
        ['AI/ML', '/technologies/ai-ml'],
        ['Automation', '/technologies/automation'],
        ['Power BI', '/technologies/power-bi'],
        ['Data Analytics', '/technologies/data-analytics'],
    ],
];

$resourcesMenu = [
    ['label' => 'Blog', 'href' => '/blog'],
    ['label' => 'Guides', 'href' => '/resources/guides'],
    ['label' => 'FAQs', 'href' => '/#faqs'],
];

$companyMenu = [
    ['label' => 'About Us', 'href' => '/about'],
    ['label' => 'Contact Us', 'href' => '/contact'],
];

$featuredTech = [
    ['ReactJS', '/hire-react-developers'],
    ['Laravel', '/hire-laravel-developers'],
    ['Flutter', '/hire-flutter-developers'],
    ['Node.js', '/hire-nodejs-developers'],
    ['AI/ML', '/technologies/ai-ml'],
];

$techCategoryShort = [
    'Frontend Technologies' => 'Frontend',
    'Backend Technologies' => 'Backend',
    'Mobile Technologies' => 'Mobile',
    'Database Technologies' => 'Database',
    'Cloud & DevOps' => 'Cloud & DevOps',
    'AI & Analytics' => 'AI & Analytics',
];
@endphp

<header
    class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-md"
    x-data="{
        mobileOpen: false,
        mobileAccordion: null,
        mobileTechCategory: null,
        mobileTechShowAll: false,
        desktopMega: null,
        closeDesktopMega() { this.desktopMega = null; },
        resetMobileTech() {
            this.mobileTechCategory = null;
            this.mobileTechShowAll = false;
        },
        toggleMobile(section) {
            if (this.mobileAccordion === section) {
                this.mobileAccordion = null;
                this.resetMobileTech();
            } else {
                this.mobileAccordion = section;
                this.resetMobileTech();
            }
        },
        toggleTechCategory(slug) {
            this.mobileTechCategory = this.mobileTechCategory === slug ? null : slug;
        }
    }"
    @keydown.escape.window="mobileOpen = false; desktopMega = null"
>
    <div class="nav-shell">
        {{-- LEFT: Logo --}}
        <a href="/" class="nav-brand" aria-label="OpacifyWeb home">
            <x-brand-logo variant="default" class="h-9 w-auto max-w-[10.5rem] sm:max-w-[11.5rem]" />
        </a>

        {{-- CENTER: Desktop navigation --}}
        <nav class="nav-desktop" aria-label="Primary" data-nav-menu>
            <div class="nav-desktop-inner">
                <a href="/" class="nav-link">Home</a>

                <div
                    class="relative"
                    @mouseenter="desktopMega = 'services'"
                    @mouseleave="desktopMega = null"
                >
                    <button
                        type="button"
                        class="nav-link"
                        :class="desktopMega === 'services' ? 'bg-slate-50 text-navy' : ''"
                        :aria-expanded="desktopMega === 'services'"
                    >
                        Services
                        <svg class="nav-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>

                <div
                    class="relative"
                    @mouseenter="desktopMega = 'technologies'"
                    @mouseleave="desktopMega = null"
                >
                    <button
                        type="button"
                        class="nav-link"
                        :class="desktopMega === 'technologies' ? 'bg-slate-50 text-navy' : ''"
                        :aria-expanded="desktopMega === 'technologies'"
                    >
                        Technologies
                        <svg class="nav-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>

                <a href="/case-studies" class="nav-link">Case Studies</a>

                <div
                    class="relative"
                    @mouseenter="desktopMega = 'resources'"
                    @mouseleave="desktopMega = null"
                >
                    <button
                        type="button"
                        class="nav-link"
                        :class="desktopMega === 'resources' ? 'bg-slate-50 text-navy' : ''"
                        :aria-expanded="desktopMega === 'resources'"
                    >
                        Resources
                        <svg class="nav-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div
                        x-show="desktopMega === 'resources'"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="nav-dropdown-panel"
                        x-cloak
                        @mouseenter="desktopMega = 'resources'"
                        @mouseleave="desktopMega = null"
                    >
                        @foreach($resourcesMenu as $item)
                            <a href="{{ $item['href'] }}" class="nav-dropdown-link">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                <div
                    class="relative"
                    @mouseenter="desktopMega = 'company'"
                    @mouseleave="desktopMega = null"
                >
                    <button
                        type="button"
                        class="nav-link"
                        :class="desktopMega === 'company' ? 'bg-slate-50 text-navy' : ''"
                        :aria-expanded="desktopMega === 'company'"
                    >
                        Company
                        <svg class="nav-link-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div
                        x-show="desktopMega === 'company'"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="nav-dropdown-panel"
                        x-cloak
                        @mouseenter="desktopMega = 'company'"
                        @mouseleave="desktopMega = null"
                    >
                        @foreach($companyMenu as $item)
                            <a href="{{ $item['href'] }}" class="nav-dropdown-link">{{ $item['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        {{-- RIGHT: CTA + mobile toggle --}}
        <div class="nav-actions">
            <a href="/contact" class="nav-cta">Get Free Quote</a>
            <button
                type="button"
                class="nav-mobile-toggle"
                @click="mobileOpen = !mobileOpen"
                :aria-expanded="mobileOpen"
                aria-label="Toggle navigation menu"
            >
                <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Full-width mega menus (fixed below header — no overlap with nav items) --}}
    <div
        x-show="desktopMega === 'services'"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="nav-mega-shell hidden xl:block"
        x-cloak
        @mouseenter="desktopMega = 'services'"
        @mouseleave="desktopMega = null"
        data-nav-menu
    >
        <div class="nav-mega-inner">
            <div class="nav-mega-grid-services">
                @foreach($servicesMenu as $item)
                    <a href="{{ $item['href'] }}" class="group nav-mega-card">
                        <span class="block text-sm font-semibold text-navy group-hover:text-brand-700">{{ $item['label'] }}</span>
                        <span class="mt-1 block text-xs leading-relaxed text-slate-500">{{ $item['desc'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div
        x-show="desktopMega === 'technologies'"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="nav-mega-shell hidden xl:block"
        x-cloak
        @mouseenter="desktopMega = 'technologies'"
        @mouseleave="desktopMega = null"
        data-nav-menu
    >
        <div class="nav-mega-inner">
            <div class="nav-mega-grid-tech">
                @foreach($techMenu as $category => $items)
                    <div class="min-w-0">
                        <p class="mb-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $category }}</p>
                        <ul class="space-y-0.5">
                            @foreach($items as [$name, $href])
                                <li>
                                    <a href="{{ $href }}" class="flex items-center gap-2 rounded-md px-2 py-2 text-sm text-slate-600 transition-colors hover:bg-brand-50 hover:text-brand-800">
                                        <x-tech-icon :tech="$name" box="h-6 w-6 rounded-md" class="h-3.5 w-3.5" />
                                        {{ $name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="nav-mobile-panel"
        @click.outside="mobileOpen = false"
    >
        <nav class="mx-auto max-w-7xl px-3 py-3 sm:px-6" aria-label="Mobile">
            <a href="/" class="nav-mobile-link" @click="mobileOpen = false">Home</a>

            <div class="mt-1 border-t border-slate-100 pt-1">
                <button type="button" class="nav-mobile-accordion-btn" @click="toggleMobile('services')" :aria-expanded="mobileAccordion === 'services'">
                    <span>Services</span>
                    <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="mobileAccordion === 'services' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="mobileAccordion === 'services'" x-transition class="space-y-0.5 pb-2 pl-2">
                    @foreach($servicesMenu as $item)
                        <a href="{{ $item['href'] }}" class="nav-mobile-sublink" @click="mobileOpen = false">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-slate-100 pt-1">
                <button type="button" class="nav-mobile-accordion-btn" @click="toggleMobile('technologies')" :aria-expanded="mobileAccordion === 'technologies'">
                    <span>Technologies</span>
                    <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="mobileAccordion === 'technologies' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div
                    x-show="mobileAccordion === 'technologies'"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="nav-mobile-tech-panel"
                    x-cloak
                >
                    <p class="nav-mobile-tech-label">Popular</p>
                    <div class="nav-mobile-tech-chips">
                        @foreach($featuredTech as [$name, $href])
                            <a href="{{ $href }}" class="nav-mobile-tech-chip" @click="mobileOpen = false">{{ $name }}</a>
                        @endforeach
                    </div>

                    <button
                        type="button"
                        class="nav-mobile-tech-toggle"
                        @click="mobileTechShowAll = !mobileTechShowAll; mobileTechCategory = null"
                        :aria-expanded="mobileTechShowAll"
                    >
                        <span x-text="mobileTechShowAll ? 'Hide categories' : 'View all technologies'"></span>
                        <svg class="h-3.5 w-3.5 text-slate-400 transition-transform duration-200" :class="mobileTechShowAll ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div
                        x-show="mobileTechShowAll"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        class="nav-mobile-tech-categories"
                    >
                        @foreach($techMenu as $category => $items)
                            @php $catSlug = 'tech-cat-' . $loop->index; @endphp
                            <div class="nav-mobile-tech-category">
                                <button
                                    type="button"
                                    class="nav-mobile-tech-category-btn"
                                    @click="toggleTechCategory('{{ $catSlug }}')"
                                    :aria-expanded="mobileTechCategory === '{{ $catSlug }}'"
                                >
                                    <span>{{ $techCategoryShort[$category] ?? $category }}</span>
                                    <svg class="h-3.5 w-3.5 shrink-0 text-slate-400 transition-transform duration-200" :class="mobileTechCategory === '{{ $catSlug }}' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div
                                    x-show="mobileTechCategory === '{{ $catSlug }}'"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="nav-mobile-tech-category-panel"
                                    x-cloak
                                >
                                    @foreach($items as [$name, $href])
                                        <a href="{{ $href }}" class="nav-mobile-tech-item flex items-center gap-2" @click="mobileOpen = false">
                                            <x-tech-icon :tech="$name" box="h-6 w-6 rounded-md" class="h-3.5 w-3.5" />
                                            {{ $name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a href="/case-studies" class="nav-mobile-link border-t border-slate-100" @click="mobileOpen = false">Case Studies</a>

            <div class="border-t border-slate-100 pt-1">
                <button type="button" class="nav-mobile-accordion-btn" @click="toggleMobile('resources')" :aria-expanded="mobileAccordion === 'resources'">
                    <span>Resources</span>
                    <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="mobileAccordion === 'resources' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="mobileAccordion === 'resources'" class="pb-2 pl-2">
                    @foreach($resourcesMenu as $item)
                        <a href="{{ $item['href'] }}" class="nav-mobile-sublink" @click="mobileOpen = false">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-slate-100 pt-1">
                <button type="button" class="nav-mobile-accordion-btn" @click="toggleMobile('company')" :aria-expanded="mobileAccordion === 'company'">
                    <span>Company</span>
                    <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="mobileAccordion === 'company' ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="mobileAccordion === 'company'" class="pb-2 pl-2">
                    @foreach($companyMenu as $item)
                        <a href="{{ $item['href'] }}" class="nav-mobile-sublink" @click="mobileOpen = false">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </div>

            <div class="mt-3 border-t border-slate-100 px-2 pt-4">
                <a href="/contact" class="flex min-h-[3rem] items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-600" @click="mobileOpen = false">
                    Get Free Quote
                </a>
            </div>
        </nav>
    </div>
</header>

<style>[x-cloak] { display: none !important; }</style>

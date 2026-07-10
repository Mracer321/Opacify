<?php

/*
 | Centralized technology page data — allowlisted by slug.
 | Resolved server-side by TechnologyPageController via a direct keyed lookup.
 | Laravel / React / Node.js / Flutter are intentionally ABSENT: their high-intent
 | search demand is served by the canonical /hire-*-developers pages, and
 | /technologies/{those} are 301-redirected there.
 |
 | Each entry is unique to the actual technology (distinct skills, use cases, and
 | hiring context). No invented counts, certifications, partnerships, or guarantees.
 */

$canonical = fn (string $slug) => 'https://opacify.in/technologies/' . $slug;

$tech = [
    // ---- Frontend ----
    'angular' => [
        'name' => 'Angular', 'headline' => 'Hire Angular Developers',
        'description' => 'Enterprise Angular engineers for large single-page apps, dashboards, and design systems built with RxJS and strong typing.',
        'rate' => '$20–$45/hour',
        'skills' => ['RxJS & reactive state', 'NgRx / signals', 'Angular Material & CDK', 'Standalone components', 'Jasmine/Karma testing', 'SSR with Angular Universal'],
        'benefits' => [
            ['Structured at scale', 'Angular suits large teams and long-lived apps, and our developers keep modules, routing, and DI maintainable.'],
            ['Typed end to end', 'Strict TypeScript, reactive forms, and interceptors reduce runtime surprises in complex UIs.'],
            ['Flexible engagement', 'Hourly, dedicated monthly, or a squad with a front-end lead.'],
        ],
        'longform' => 'Angular is the framework of choice for data-heavy enterprise front-ends such as admin consoles, insurance portals, and internal tooling. Our developers have migrated legacy AngularJS apps, introduced NgRx where state complexity warranted it, and kept bundle sizes in check with lazy-loaded routes.',
    ],
    'vue' => [
        'name' => 'Vue.js', 'headline' => 'Hire Vue.js Developers',
        'description' => 'Vue 3 developers for approachable, fast SPAs and embedded widgets using the Composition API and Pinia.',
        'rate' => '$18–$42/hour',
        'skills' => ['Vue 3 Composition API', 'Pinia state', 'Vue Router', 'Nuxt SSR/SSG', 'Vitest & Testing Library', 'Component libraries'],
        'benefits' => [
            ['Fast to ship', 'Vue’s gentle learning curve and single-file components speed up feature delivery.'],
            ['Incremental adoption', 'Drop Vue into an existing page or build a full Nuxt app. Our developers do both.'],
            ['Flexible engagement', 'Hourly, dedicated, or fixed-scope with QA included.'],
        ],
        'longform' => 'Vue powers everything from marketing sites to embedded dashboards. Our developers build with the Composition API and Pinia, and reach for Nuxt when SEO and server rendering matter. Common work includes admin panels, customer portals, and interactive widgets embedded in existing stacks.',
    ],
    'nextjs' => [
        'name' => 'Next.js', 'headline' => 'Hire Next.js Developers',
        'description' => 'Next.js engineers for SSR/SSG React apps with the App Router, server components, and edge-ready deployments.',
        'rate' => '$22–$48/hour',
        'skills' => ['App Router & server components', 'SSR / SSG / ISR', 'API routes & server actions', 'SEO & Core Web Vitals', 'Vercel / self-hosted deploys', 'TypeScript'],
        'benefits' => [
            ['SEO by default', 'Server rendering and static generation give marketing and content pages strong crawlability.'],
            ['One codebase', 'Frontend and backend routes live together, reducing hand-offs for lean teams.'],
            ['Flexible engagement', 'Hourly advisory through a dedicated product squad.'],
        ],
        'longform' => 'Next.js is our default for React apps that need SEO, fast first paint, and a unified data layer. Developers work across the App Router, server actions, and caching strategies, and tune Core Web Vitals for content-heavy and commerce sites alike.',
    ],
    'html5' => [
        'name' => 'HTML5', 'headline' => 'Hire HTML5 Developers',
        'description' => 'HTML5 specialists for semantic, accessible markup and standards-based interactive front-ends.',
        'rate' => '$15–$35/hour',
        'skills' => ['Semantic markup', 'WCAG accessibility', 'Canvas & SVG', 'Responsive templates', 'Web components', 'Email/AMP markup'],
        'benefits' => [
            ['Accessible & semantic', 'Correct landmarks, ARIA, and keyboard support, not div soup.'],
            ['Cross-device', 'Markup that holds up across browsers, screen readers, and viewports.'],
            ['Flexible engagement', 'Task-based or embedded with your design team.'],
        ],
        'longform' => 'Solid HTML5 is the foundation of accessible, performant products. Our developers author semantic templates, build reusable web components, and remediate accessibility issues so interfaces work for every user and rank well.',
    ],
    'css3' => [
        'name' => 'CSS3', 'headline' => 'Hire CSS3 Developers',
        'description' => 'CSS engineers for pixel-accurate, responsive interfaces, design systems, and animation.',
        'rate' => '$15–$35/hour',
        'skills' => ['Flexbox & Grid', 'CSS custom properties', 'Responsive & container queries', 'Animations & transitions', 'Sass / PostCSS', 'Design-system theming'],
        'benefits' => [
            ['Pixel accurate', 'Faithful translation of Figma into responsive, maintainable styles.'],
            ['Systemized', 'Tokens and utilities instead of one-off overrides.'],
            ['Flexible engagement', 'Hourly styling support or full front-end delivery.'],
        ],
        'longform' => 'Great CSS is the difference between a design that ships and one that drifts. Our developers build token-driven design systems, complex responsive layouts, and performant animations without bloated stylesheets.',
    ],
    'javascript' => [
        'name' => 'JavaScript', 'headline' => 'Hire JavaScript Developers',
        'description' => 'Core JavaScript engineers for interactive front-ends, browser APIs, and framework-agnostic components.',
        'rate' => '$18–$42/hour',
        'skills' => ['ES2020+ language features', 'DOM & browser APIs', 'Async & fetch patterns', 'Bundlers (Vite/Webpack)', 'Jest / Vitest testing', 'Performance profiling'],
        'benefits' => [
            ['Framework-agnostic', 'Strong fundamentals transfer across React, Vue, and vanilla codebases.'],
            ['Performance-aware', 'Developers profile and fix jank, memory leaks, and slow bundles.'],
            ['Flexible engagement', 'Hourly, dedicated, or project-based.'],
        ],
        'longform' => 'Beneath every framework is JavaScript. Our developers debug tricky async flows, optimise bundles, and build framework-agnostic widgets and SDKs that other teams embed into their own products.',
    ],
    'typescript' => [
        'name' => 'TypeScript', 'headline' => 'Hire TypeScript Developers',
        'description' => 'TypeScript engineers who bring type safety to front-end and Node back-end codebases.',
        'rate' => '$20–$45/hour',
        'skills' => ['Advanced generics & utility types', 'Strict config & migration', 'Typed API clients', 'tRPC / Zod validation', 'Monorepo tooling', 'Node & browser typing'],
        'benefits' => [
            ['Fewer runtime bugs', 'Types catch whole classes of defects before they reach production.'],
            ['Safer refactors', 'Confident large-scale changes across shared code.'],
            ['Flexible engagement', 'Migration sprints or long-term dedicated work.'],
        ],
        'longform' => 'We use TypeScript across most engagements. Developers migrate JavaScript codebases incrementally, design shared type packages for monorepos, and add end-to-end typing from database to UI with tools like Zod and tRPC.',
    ],
    'tailwind' => [
        'name' => 'Tailwind CSS', 'headline' => 'Hire Tailwind CSS Developers',
        'description' => 'Tailwind developers for consistent, utility-driven UI and maintainable design systems.',
        'rate' => '$18–$40/hour',
        'skills' => ['Utility-first workflow', 'Theme & token config', 'Component extraction', 'Dark mode & theming', 'Headless UI / Radix', 'JIT & build optimization'],
        'benefits' => [
            ['Consistent UI', 'Design tokens in config keep spacing, color, and type uniform.'],
            ['Lean output', 'Purged, JIT-built CSS keeps payloads small.'],
            ['Flexible engagement', 'Design-system setup or ongoing front-end delivery.'],
        ],
        'longform' => 'Tailwind lets small teams ship consistent interfaces fast. Our developers centralise brand tokens in config, extract sensible components, and keep production CSS lean, so the design system scales without fighting specificity.',
    ],
    'bootstrap' => [
        'name' => 'Bootstrap', 'headline' => 'Hire Bootstrap Developers',
        'description' => 'Bootstrap developers for rapid, responsive interfaces and admin themes on a familiar grid.',
        'rate' => '$15–$35/hour',
        'skills' => ['Grid & responsive layout', 'Sass customization', 'Component theming', 'Admin dashboard templates', 'Accessibility tweaks', 'jQuery interop'],
        'benefits' => [
            ['Rapid delivery', 'Proven components speed up internal tools and MVPs.'],
            ['Themeable', 'Sass overrides move you beyond the default look.'],
            ['Flexible engagement', 'Task-based or embedded delivery.'],
        ],
        'longform' => 'Bootstrap remains a pragmatic choice for internal tools and quick MVPs. Our developers customise it via Sass so products don’t look generic, and modernise older Bootstrap apps toward maintainable components.',
    ],

    // ---- Backend ----
    'php' => [
        'name' => 'PHP', 'headline' => 'Hire PHP Developers',
        'description' => 'PHP engineers for secure web backends, APIs, and modernization of legacy applications.',
        'rate' => '$16–$40/hour',
        'skills' => ['PHP 8.x & OOP', 'Laravel / Symfony', 'REST APIs & auth', 'MySQL & query tuning', 'Composer & PSR standards', 'Legacy modernization'],
        'benefits' => [
            ['Broad ecosystem', 'Our developers work across the full PHP stack, including WordPress and Laravel.'],
            ['Security-minded', 'Input validation, prepared statements, and safe file handling by default.'],
            ['Flexible engagement', 'Hourly fixes, dedicated build, or legacy rescue.'],
        ],
        'longform' => 'PHP still runs a large share of the web. Our developers build modern PHP 8 services with Laravel or Symfony, tune slow MySQL queries, and incrementally refactor legacy codebases without freezing the business.',
    ],
    'python' => [
        'name' => 'Python', 'headline' => 'Hire Python Developers',
        'description' => 'Python engineers for APIs, automation, data pipelines, and Django/FastAPI backends.',
        'rate' => '$20–$48/hour',
        'skills' => ['Django / FastAPI', 'Async & typing', 'Pandas & data pipelines', 'Celery task queues', 'PostgreSQL', 'pytest'],
        'benefits' => [
            ['Versatile', 'One language spanning web APIs, automation, and data work.'],
            ['Readable & tested', 'Typed, pytest-covered code that new team members can pick up.'],
            ['Flexible engagement', 'Advisory, dedicated, or a blended data + backend squad.'],
        ],
        'longform' => 'Python is our go-to for backends that touch data and automation. Developers ship FastAPI and Django services, build ETL and scheduled jobs with Celery, and wire APIs to analytics and ML workflows.',
    ],
    'java' => [
        'name' => 'Java', 'headline' => 'Hire Java Developers',
        'description' => 'Java engineers for reliable enterprise services, high-throughput APIs, and JVM performance work.',
        'rate' => '$22–$50/hour',
        'skills' => ['Core Java & concurrency', 'Spring ecosystem', 'JPA / Hibernate', 'Microservices', 'JUnit & testing', 'JVM tuning'],
        'benefits' => [
            ['Built for scale', 'Java suits transaction-heavy, long-running enterprise systems.'],
            ['Strong tooling', 'Mature testing, profiling, and observability practices.'],
            ['Flexible engagement', 'Dedicated engineers or a service-oriented squad.'],
        ],
        'longform' => 'Java underpins banking, logistics, and large SaaS backends. Our developers design microservices, tune JVM and database performance, and maintain the reliability and observability these systems demand.',
    ],
    'spring-boot' => [
        'name' => 'Spring Boot', 'headline' => 'Hire Spring Boot Developers',
        'description' => 'Spring Boot developers for production-grade Java microservices and secure REST APIs.',
        'rate' => '$24–$52/hour',
        'skills' => ['Spring Boot & Web', 'Spring Security & JWT', 'Spring Data JPA', 'Microservice patterns', 'Actuator & observability', 'Docker deploys'],
        'benefits' => [
            ['Convention over config', 'Faster delivery on a hardened, well-understood stack.'],
            ['Secure by design', 'Spring Security integrated with your auth model.'],
            ['Flexible engagement', 'Hourly through dedicated squads.'],
        ],
        'longform' => 'Spring Boot is the standard for modern Java services. Our developers build secured REST and messaging services, add health checks and metrics via Actuator, and containerise for cloud or on-prem deployment.',
    ],
    'rest-apis' => [
        'name' => 'REST APIs', 'headline' => 'Hire REST API Developers',
        'description' => 'API engineers who design versioned, well-documented REST services with auth, rate limiting, and testing.',
        'rate' => '$20–$46/hour',
        'skills' => ['Resource & versioning design', 'OAuth2 / JWT auth', 'OpenAPI documentation', 'Rate limiting & pagination', 'Contract & integration tests', 'Webhooks'],
        'benefits' => [
            ['Integration-ready', 'Clean contracts that partner teams and mobile apps consume easily.'],
            ['Documented', 'OpenAPI specs and examples reduce back-and-forth.'],
            ['Flexible engagement', 'API-only builds or full backend delivery.'],
        ],
        'longform' => 'A dependable API is the backbone of web, mobile, and partner integrations. Our developers design consistent, versioned REST services with proper auth, pagination, and OpenAPI docs, and back them with contract tests.',
    ],

    // ---- Mobile ----
    'react-native' => [
        'name' => 'React Native', 'headline' => 'Hire React Native Developers',
        'description' => 'React Native engineers for cross-platform iOS and Android apps from a shared TypeScript codebase.',
        'rate' => '$22–$48/hour',
        'skills' => ['React Native & Expo', 'Navigation & state', 'Native modules bridging', 'Push & deep linking', 'App Store / Play releases', 'Performance profiling'],
        'benefits' => [
            ['One codebase', 'Ship iOS and Android together without two native teams.'],
            ['Native when needed', 'Developers drop to native modules for camera, BLE, or performance.'],
            ['Flexible engagement', 'Dedicated app team or feature-based work.'],
        ],
        'longform' => 'React Native lets startups reach both platforms with one team. Our developers build with Expo where it fits, bridge to native modules where it doesn’t, and own store submissions, OTA updates, and release monitoring.',
    ],
    'android' => [
        'name' => 'Android', 'headline' => 'Hire Android Developers',
        'description' => 'Native Android engineers building Kotlin apps with Jetpack Compose and modern architecture.',
        'rate' => '$22–$48/hour',
        'skills' => ['Kotlin & coroutines', 'Jetpack Compose', 'MVVM & architecture components', 'Room & DataStore', 'Play Store releases', 'Espresso testing'],
        'benefits' => [
            ['Native performance', 'Full access to device capabilities and smooth UI.'],
            ['Modern stack', 'Compose and Jetpack over legacy patterns.'],
            ['Flexible engagement', 'Dedicated or feature-based delivery.'],
        ],
        'longform' => 'When Android performance and platform depth matter, native wins. Our developers build Kotlin apps with Jetpack Compose, handle background work and offline sync, and manage staged Play Store rollouts.',
    ],
    'ios' => [
        'name' => 'iOS', 'headline' => 'Hire iOS Developers',
        'description' => 'Native iOS engineers building Swift apps with SwiftUI and App Store release discipline.',
        'rate' => '$24–$52/hour',
        'skills' => ['Swift & concurrency', 'SwiftUI & UIKit', 'Core Data', 'Push & in-app purchase', 'App Store submission', 'XCTest'],
        'benefits' => [
            ['Polished UX', 'Native iOS interactions users expect on Apple devices.'],
            ['Release-ready', 'TestFlight, review compliance, and phased releases handled.'],
            ['Flexible engagement', 'Dedicated engineers or scoped features.'],
        ],
        'longform' => 'iOS users expect polish. Our developers build Swift apps with SwiftUI and UIKit, integrate StoreKit and push, and navigate App Store review and privacy requirements so releases land smoothly.',
    ],

    // ---- Databases ----
    'mysql' => [
        'name' => 'MySQL', 'headline' => 'Hire MySQL Developers',
        'description' => 'MySQL specialists for schema design, query tuning, and reliable operational databases.',
        'rate' => '$18–$44/hour',
        'skills' => ['Schema & index design', 'Query optimization', 'Replication & backups', 'Partitioning', 'Stored procedures', 'Migration tooling'],
        'benefits' => [
            ['Faster queries', 'Index and query tuning that cuts response times measurably.'],
            ['Reliable', 'Replication, backups, and recovery planning built in.'],
            ['Flexible engagement', 'Audit-only or embedded with your backend team.'],
        ],
        'longform' => 'MySQL runs a huge share of production apps. Our developers redesign slow schemas, rewrite N+1 and full-scan queries, and set up replication and backup strategies that hold up under real load.',
    ],
    'postgresql' => [
        'name' => 'PostgreSQL', 'headline' => 'Hire PostgreSQL Developers',
        'description' => 'PostgreSQL engineers for advanced schema design, JSONB, and query performance at scale.',
        'rate' => '$20–$46/hour',
        'skills' => ['Advanced indexing (GIN/BRIN)', 'JSONB & full-text search', 'Window functions & CTEs', 'Partitioning', 'Logical replication', 'EXPLAIN analysis'],
        'benefits' => [
            ['Powerful features', 'JSONB, full-text search, and rich indexing beyond basic SQL.'],
            ['Tuned for scale', 'Query plans analysed and partitioning applied where it helps.'],
            ['Flexible engagement', 'Performance audits or ongoing data work.'],
        ],
        'longform' => 'PostgreSQL rewards teams that use its depth. Our developers exploit JSONB, full-text search, and window functions, analyse query plans with EXPLAIN, and introduce partitioning and replication as data grows.',
    ],
    'mongodb' => [
        'name' => 'MongoDB', 'headline' => 'Hire MongoDB Developers',
        'description' => 'MongoDB engineers for document data modeling, aggregation pipelines, and scalable clusters.',
        'rate' => '$20–$46/hour',
        'skills' => ['Document data modeling', 'Aggregation pipelines', 'Indexing strategy', 'Sharding & replica sets', 'Atlas operations', 'Change streams'],
        'benefits' => [
            ['Flexible schema', 'Document models that fit evolving product data.'],
            ['Scales out', 'Sharding and replica sets for growth and availability.'],
            ['Flexible engagement', 'Modeling reviews or full backend delivery.'],
        ],
        'longform' => 'MongoDB fits products with flexible, nested data. Our developers design document schemas that avoid anti-patterns, build aggregation pipelines for reporting, and operate replica sets and sharding on Atlas or self-hosted.',
    ],
    'firebase' => [
        'name' => 'Firebase', 'headline' => 'Hire Firebase Developers',
        'description' => 'Firebase developers for realtime apps, authentication, and serverless backends on Google Cloud.',
        'rate' => '$20–$44/hour',
        'skills' => ['Firestore & Realtime DB', 'Firebase Auth', 'Cloud Functions', 'Security rules', 'Cloud Messaging', 'Hosting & Analytics'],
        'benefits' => [
            ['Fast to launch', 'Auth, database, and hosting without standing up servers.'],
            ['Realtime', 'Live sync for chat, collaboration, and dashboards.'],
            ['Flexible engagement', 'MVP builds or feature work on existing apps.'],
        ],
        'longform' => 'Firebase gets realtime products to market quickly. Our developers model Firestore data, write hardened security rules, and move heavier logic into Cloud Functions, keeping client apps thin and costs predictable.',
    ],

    // ---- DevOps / Cloud ----
    'docker' => [
        'name' => 'Docker', 'headline' => 'Hire Docker Developers',
        'description' => 'Docker engineers for reproducible builds, container images, and consistent dev-to-prod environments.',
        'rate' => '$22–$48/hour',
        'skills' => ['Dockerfile optimization', 'Multi-stage builds', 'Docker Compose', 'Image security scanning', 'Registry workflows', 'Container debugging'],
        'benefits' => [
            ['Consistent environments', 'The same image runs on a laptop and in production.'],
            ['Lean images', 'Multi-stage builds and layer caching cut size and build time.'],
            ['Flexible engagement', 'Containerization sprints or ongoing DevOps support.'],
        ],
        'longform' => 'Docker removes “works on my machine” problems. Our developers write lean, multi-stage images, compose local environments that mirror production, and scan images for vulnerabilities before they ship.',
    ],
    'jenkins' => [
        'name' => 'Jenkins', 'headline' => 'Hire Jenkins Developers',
        'description' => 'Jenkins engineers for reliable CI/CD pipelines, automated testing, and repeatable deployments.',
        'rate' => '$22–$48/hour',
        'skills' => ['Declarative pipelines', 'Shared libraries', 'Automated test gates', 'Credentials & secrets', 'Agent scaling', 'Deployment automation'],
        'benefits' => [
            ['Automated delivery', 'Every commit builds, tests, and deploys without manual steps.'],
            ['Maintainable pipelines', 'Declarative, version-controlled Jenkinsfiles over click-ops.'],
            ['Flexible engagement', 'Pipeline setup or ongoing platform work.'],
        ],
        'longform' => 'Jenkins still runs a large share of enterprise CI. Our developers replace brittle freestyle jobs with declarative pipelines and shared libraries, add test and security gates, and automate deployments end to end.',
    ],
    'github' => [
        'name' => 'GitHub', 'headline' => 'Hire GitHub & Actions Developers',
        'description' => 'GitHub Actions engineers for CI/CD workflows, branch protection, and automated release pipelines.',
        'rate' => '$22–$48/hour',
        'skills' => ['GitHub Actions workflows', 'Reusable & matrix jobs', 'Branch protection & reviews', 'Environments & secrets', 'Release automation', 'Dependabot / code scanning'],
        'benefits' => [
            ['Native CI/CD', 'Pipelines that live next to your code with minimal setup.'],
            ['Secure workflow', 'Branch protection, required checks, and secret hygiene.'],
            ['Flexible engagement', 'Workflow setup or ongoing automation.'],
        ],
        'longform' => 'GitHub Actions keeps CI/CD close to the code. Our developers build reusable and matrix workflows, enforce branch protection and required checks, and automate testing, scanning, and releases.',
    ],
    'cicd' => [
        'name' => 'CI/CD', 'headline' => 'Hire CI/CD Engineers',
        'description' => 'CI/CD engineers who automate build, test, and release so teams ship safely and often.',
        'rate' => '$24–$50/hour',
        'skills' => ['Pipeline design', 'Automated testing gates', 'Blue-green & canary releases', 'Rollback strategy', 'Secrets management', 'Release observability'],
        'benefits' => [
            ['Ship confidently', 'Automated gates catch regressions before users do.'],
            ['Faster releases', 'From weekly manual deploys to on-demand delivery.'],
            ['Flexible engagement', 'Pipeline builds or platform partnership.'],
        ],
        'longform' => 'CI/CD is what lets teams ship daily without fear. Our engineers design pipelines with real test gates, safe release strategies like canary and blue-green, and rollback plans, so velocity doesn’t cost reliability.',
    ],
    'cloud-deployment' => [
        'name' => 'Cloud Deployment', 'headline' => 'Hire Cloud Deployment Engineers',
        'description' => 'Cloud engineers for reliable deployments, infrastructure-as-code, and cost-aware scaling.',
        'rate' => '$24–$52/hour',
        'skills' => ['AWS / GCP / Azure basics', 'Infrastructure as code', 'Load balancing & autoscaling', 'Monitoring & alerts', 'Zero-downtime deploys', 'Cost optimization'],
        'benefits' => [
            ['Reliable releases', 'Repeatable, zero-downtime deployments over manual SSH.'],
            ['Cost-aware', 'Right-sizing and autoscaling that fit your budget.'],
            ['Flexible engagement', 'Migration projects or ongoing operations.'],
        ],
        'longform' => 'Getting to the cloud is one thing; running there well is another. Our engineers codify infrastructure, set up load balancing, autoscaling, and monitoring, and tune spend so deployments are reliable and affordable.',
    ],
    'aws' => [
        'name' => 'AWS', 'headline' => 'Hire AWS Developers',
        'description' => 'AWS engineers for scalable architecture, serverless, and well-architected cloud infrastructure.',
        'rate' => '$26–$55/hour',
        'skills' => ['EC2, S3, RDS', 'Lambda & serverless', 'VPC & IAM', 'CloudFormation / Terraform', 'CloudWatch monitoring', 'Cost management'],
        'benefits' => [
            ['Scalable architecture', 'Designs that grow from MVP to high traffic on AWS primitives.'],
            ['Secure foundations', 'Least-privilege IAM and sensible network boundaries.'],
            ['Flexible engagement', 'Architecture reviews or hands-on delivery.'],
        ],
        'longform' => 'AWS offers depth that’s easy to misuse. Our developers design right-sized architectures with EC2, RDS, S3, and Lambda, lock down IAM and networking, and manage infrastructure as code with clear cost visibility.',
    ],

    // ---- Data & AI ----
    'ai-ml' => [
        'name' => 'AI/ML', 'headline' => 'Hire AI & ML Developers',
        'description' => 'AI/ML engineers for practical model integration, LLM features, and data-driven product capabilities.',
        'rate' => '$28–$60/hour',
        'skills' => ['LLM & API integration', 'Retrieval-augmented generation', 'Model fine-tuning basics', 'Python ML tooling', 'Evaluation & guardrails', 'MLOps deployment'],
        'benefits' => [
            ['Practical, not hype', 'Focus on features that ship and measurably help users.'],
            ['Responsible', 'Evaluation, guardrails, and cost controls around model use.'],
            ['Flexible engagement', 'Prototype sprints or embedded product work.'],
        ],
        'longform' => 'Most AI value comes from careful integration, not novel research. Our developers add LLM-powered search, summarisation, and assistants with retrieval, evaluation, and guardrails. They also keep latency and token costs under control.',
    ],
    'automation' => [
        'name' => 'Automation', 'headline' => 'Hire Automation Developers',
        'description' => 'Automation engineers who eliminate manual work with scripts, integrations, and workflow tooling.',
        'rate' => '$22–$48/hour',
        'skills' => ['Workflow automation', 'API & webhook integration', 'Scripting (Python/Node)', 'RPA & schedulers', 'Data sync & ETL', 'Error handling & alerts'],
        'benefits' => [
            ['Less manual work', 'Repetitive tasks handled reliably by code.'],
            ['Connected tools', 'Systems that talk to each other via APIs and webhooks.'],
            ['Flexible engagement', 'Focused automation sprints or ongoing work.'],
        ],
        'longform' => 'Manual processes quietly drain teams. Our developers automate them by syncing systems over APIs, scripting recurring jobs, and building workflows with proper error handling and alerts so automation is trustworthy.',
    ],
    'power-bi' => [
        'name' => 'Power BI', 'headline' => 'Hire Power BI Developers',
        'description' => 'Power BI developers for clean data models, DAX measures, and decision-ready dashboards.',
        'rate' => '$22–$48/hour',
        'skills' => ['Data modeling & star schema', 'DAX measures', 'Power Query / M', 'Report & dashboard design', 'Row-level security', 'Scheduled refresh'],
        'benefits' => [
            ['Trustworthy numbers', 'Sound models and DAX that stakeholders can rely on.'],
            ['Decision-ready', 'Dashboards designed around the questions leaders actually ask.'],
            ['Flexible engagement', 'One-off dashboards or ongoing BI support.'],
        ],
        'longform' => 'A dashboard is only as good as its model. Our developers shape clean star-schema models, write correct DAX, and design Power BI reports with row-level security and scheduled refresh so decisions rest on reliable data.',
    ],
    'data-analytics' => [
        'name' => 'Data Analytics', 'headline' => 'Hire Data Analytics Developers',
        'description' => 'Analytics engineers for pipelines, metrics, and reporting that turn raw data into decisions.',
        'rate' => '$24–$50/hour',
        'skills' => ['SQL & data modeling', 'ETL / ELT pipelines', 'Metrics & KPI definition', 'Warehouse tooling', 'Dashboarding', 'Data quality checks'],
        'benefits' => [
            ['Single source of truth', 'Consistent, documented metrics across teams.'],
            ['Actionable', 'Reporting built around decisions, not vanity charts.'],
            ['Flexible engagement', 'Pipeline builds or embedded analytics work.'],
        ],
        'longform' => 'Analytics only helps when the numbers are trusted and timely. Our engineers build ETL/ELT pipelines, define metrics consistently, add data-quality checks, and deliver reporting that answers real business questions.',
    ],
];

// Normalize: attach slug, canonical, and unique meta fields to every entry.
$technologies = [];
foreach ($tech as $slug => $data) {
    $technologies[$slug] = array_merge([
        'slug' => $slug,
        'canonical' => $canonical($slug),
        'meta_title' => $data['headline'] . ' | OpacifyWeb',
        'meta_description' => $data['description'],
    ], $data);
}

return $technologies;

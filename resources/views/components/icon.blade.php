@props([
    'name',
    'class' => 'h-5 w-5',
])

@php
// Semantic mapping: existing icon keys (used across pages/data arrays) -> real Lucide icon names.
// Generic marketing/UI/feature icons only. Technology brand logos live in <x-tech-icon> and are NOT mapped here.
$lucideMap = [
    // Generic UI
    'arrow-right' => 'arrow-right',
    'check' => 'check',
    'check-circle' => 'bug',              // only used for "QA & Testing"
    'chat' => 'message-square',
    'help' => 'circle-help',
    'document' => 'file-text',
    'globe' => 'globe',
    'lock' => 'lock',
    'shield' => 'shield',
    'shield-check' => 'shield-check',
    'shield-lock' => 'shield-check',
    'sparkles' => 'sparkles',
    'workflow' => 'workflow',
    'cpu' => 'cpu',
    'chart' => 'trending-up',
    'chart-bar-square' => 'trending-up',
    'presentation-chart-line' => 'line-chart',
    // Services / capabilities
    'computer-desktop' => 'app-window',   // Web Development / Frontend
    'smartphone' => 'smartphone',
    'building-office' => 'building-2',     // ERP
    'command-line' => 'terminal',          // Software Development
    'megaphone' => 'megaphone',            // Digital Marketing
    'code' => 'code',
    'code-window' => 'layers',             // Full-Stack
    'layers' => 'network',                 // Architect
    'server' => 'server',                  // Backend
    'circle-stack' => 'server',            // "Backend & APIs"
    'database' => 'database',
    'cloud' => 'cloud',
    'cloud-arrow-up' => 'cloud',           // DevOps
    // Engagement / delivery
    'clock' => 'clock',                    // Hourly / response time
    'clock-currency' => 'clock',
    'identification' => 'user-check',      // Dedicated developer
    'user-check' => 'user-check',
    'briefcase' => 'briefcase',            // Full project
    'user-plus' => 'user-plus',            // Staff augmentation
    'users' => 'users',                    // Dedicated squad / team
    'user-group' => 'users',
    'flag' => 'flag',                      // Milestone project
    'rocket-launch' => 'rocket',           // Start delivery / pilot
    // Process
    'clipboard-document' => 'clipboard-list',
    'clipboard-document-list' => 'clipboard-list',
    'clipboard-document-check' => 'clipboard-check',
    // Business / contact
    'currency' => 'circle-dollar-sign',
    'mail' => 'mail',
    'phone' => 'phone',
    'map-pin' => 'map-pin',
];

// Fall through to the given name if it is already a valid Lucide name.
$lucide = $lucideMap[$name] ?? $name;
@endphp

<i data-lucide="{{ $lucide }}" {{ $attributes->merge(['class' => trim($class)]) }} aria-hidden="true"></i>

<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Seeds the original demo blog posts so existing public URLs, titles and the
 * sitemap remain intact after the move from the static data file to the DB.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function posts(): array
    {
        return [
            [
                'slug' => 'how-to-hire-laravel-developers',
                'title' => 'How to Hire Laravel Developers Without a Six-Month Search',
                'excerpt' => 'A practical framework for evaluating Laravel talent, structuring trials, and avoiding common outsourcing pitfalls.',
                'category' => 'Hiring',
                'tags' => ['laravel', 'hiring'],
                'author' => 'Neha Kapoor',
                'author_role' => 'Head of Delivery',
                'read_minutes' => 8,
                'status' => BlogPost::STATUS_PUBLISHED,
                'published_at' => Carbon::parse('2026-05-12 09:00:00'),
                'content_blocks' => [
                    ['type' => 'paragraph', 'text' => 'Hiring Laravel developers should not feel like gambling. Yet many teams rush into job boards, receive hundreds of unvetted applicants, and lose a quarter before the first meaningful commit lands in production.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Start with outcomes, not job titles'],
                    ['type' => 'paragraph', 'text' => 'Write a brief that specifies version constraints (Laravel 10 vs 11), integration surfaces (Stripe, Salesforce), and expected ceremony: daily standups, pair programming, or async updates. Senior developers self-select when expectations are concrete.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Run a structured technical review'],
                    ['type' => 'paragraph', 'text' => 'We recommend a 90-minute review: 30 minutes on past projects, 30 minutes on architecture discussion (caching, queues, authorization), and 30 minutes on a take-home or live refactoring exercise scoped to your domain, not algorithm trivia.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Define a trial sprint'],
                    ['type' => 'paragraph', 'text' => 'A two-week paid trial on a real backlog item reveals communication style and code hygiene faster than reference checks alone. Document acceptance criteria upfront so both sides can evaluate fairly.'],
                    ['type' => 'quote', 'text' => 'Teams that define trial acceptance criteria in writing onboard 40% faster than those relying on vague "see how it goes" agreements.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'When agency support helps'],
                    ['type' => 'paragraph', 'text' => 'If you need replacement coverage, consolidated invoicing, or NDA management across jurisdictions, a partner like OpacifyWeb reduces operational overhead, while you still interview and manage day-to-day engineering.'],
                    ['type' => 'paragraph', 'text' => 'Ready to see Laravel profiles matched to your brief? [Request a free quote](/contact) and we will respond within one business day.'],
                ],
            ],
            [
                'slug' => 'dedicated-developer-vs-hourly',
                'title' => 'Dedicated Developer vs Hourly: Which Model Fits Your Roadmap?',
                'excerpt' => 'Compare cost predictability, velocity, and governance across engagement models before you sign.',
                'category' => 'Strategy',
                'tags' => ['teams', 'hiring'],
                'author' => 'Neha Kapoor',
                'author_role' => 'Head of Delivery',
                'read_minutes' => 6,
                'status' => BlogPost::STATUS_PUBLISHED,
                'published_at' => Carbon::parse('2026-04-28 09:00:00'),
                'content_blocks' => [
                    ['type' => 'paragraph', 'text' => 'Choosing between a dedicated developer and hourly engagement comes down to how predictable your roadmap is. Steady, multi-month work rewards a dedicated retainer; spiky or advisory work fits hourly.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'When hourly wins'],
                    ['type' => 'paragraph', 'text' => 'Audits, spikes, and short bursts of senior expertise are best billed hourly. You pay only for the hours you use and can scale up or down weekly.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'When dedicated wins'],
                    ['type' => 'paragraph', 'text' => 'For sprint-based delivery with shared context and consistent velocity, a dedicated developer embedded in your rituals removes ramp-up cost and keeps ownership high.'],
                ],
            ],
            [
                'slug' => 'react-team-augmentation-checklist',
                'title' => 'The React Team Augmentation Checklist for Series A Startups',
                'excerpt' => 'What to prepare in design systems, repos, and ceremonies before your first frontend contractor joins.',
                'category' => 'Frontend',
                'tags' => ['react', 'teams'],
                'author' => 'Neha Kapoor',
                'author_role' => 'Head of Delivery',
                'read_minutes' => 7,
                'status' => BlogPost::STATUS_PUBLISHED,
                'published_at' => Carbon::parse('2026-04-15 09:00:00'),
                'content_blocks' => [
                    ['type' => 'paragraph', 'text' => 'Augmenting a React team is far smoother when the groundwork is in place before the contractor starts. A little preparation converts week-one confusion into week-one commits.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Prepare before day one'],
                    ['type' => 'list', 'style' => 'bulleted', 'items' => [
                        'A documented design system or component library',
                        'Repository access, environment variables, and a working local setup guide',
                        'Clear definition of done and PR review expectations',
                        'Standups and async update cadence agreed in writing',
                    ]],
                    ['type' => 'paragraph', 'text' => 'With these in place, a senior React engineer can contribute to your component library and ship UI within the first sprint.'],
                ],
            ],
            [
                'slug' => 'erp-migration-lessons',
                'title' => 'Five Lessons from Migrating a Legacy ERP to Laravel',
                'excerpt' => 'Data migration, user training, and phased rollouts. Here is what actually reduced downtime.',
                'category' => 'Case insights',
                'tags' => ['laravel', 'devops'],
                'author' => 'Neha Kapoor',
                'author_role' => 'Head of Delivery',
                'read_minutes' => 10,
                'status' => BlogPost::STATUS_PUBLISHED,
                'published_at' => Carbon::parse('2026-03-30 09:00:00'),
                'content_blocks' => [
                    ['type' => 'paragraph', 'text' => 'Migrating a legacy ERP to Laravel is as much about people and process as it is about code. These five lessons came from a real, phased migration that kept the business running throughout.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Phase the rollout'],
                    ['type' => 'paragraph', 'text' => 'Moving one module at a time, starting with the lowest-risk workflow, let us validate data integrity and train users without a big-bang cutover.'],
                    ['type' => 'heading', 'level' => 2, 'text' => 'Invest in data migration early'],
                    ['type' => 'paragraph', 'text' => 'Reconciling legacy data against the new schema surfaced edge cases long before go-live, which is exactly when you want to find them.'],
                ],
            ],
        ];
    }
}

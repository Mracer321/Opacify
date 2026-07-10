<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            // Identity / routing
            $table->string('title', 200);
            $table->string('slug', 200)->unique();

            // Listing / summary
            $table->string('excerpt', 500)->nullable();
            $table->string('category', 120)->nullable();
            $table->json('tags')->nullable();

            // Authorship
            $table->string('author', 120);
            $table->string('author_role', 160)->nullable();
            $table->unsignedSmallInteger('read_minutes')->nullable();

            // Rich body: ordered list of typed content blocks (safe, no raw HTML)
            $table->json('content_blocks')->nullable();

            // Featured image (public disk path) + accessibility metadata
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt', 300)->nullable();

            // Publishing / scheduling (visibility is query-based on published_at)
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();

            // SEO overrides — all optional, sensible fallbacks applied at render time
            $table->string('seo_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('canonical_url', 300)->nullable();
            $table->string('og_title', 200)->nullable();
            $table->string('og_description', 300)->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('robots_noindex')->default(false);
            $table->boolean('robots_nofollow')->default(false);

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};

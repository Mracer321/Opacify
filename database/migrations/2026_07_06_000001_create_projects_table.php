<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Identity / routing
            $table->string('title', 160);
            $table->string('slug', 180)->unique();
            $table->string('project_label', 120);

            // Listing / homepage
            $table->string('short_summary', 500);
            $table->string('industry', 120);
            $table->string('duration', 80);
            $table->json('technologies')->nullable();
            $table->json('highlights')->nullable();

            // Detail content
            $table->text('challenge');
            $table->text('solution');
            $table->string('team_summary', 255);
            $table->json('key_results')->nullable();

            // Optional testimonial
            $table->string('testimonial_quote', 1000)->nullable();
            $table->string('testimonial_name', 120)->nullable();
            $table->string('testimonial_role', 160)->nullable();

            // Media (stored filesystem paths on the public disk)
            $table->string('primary_image')->nullable();
            $table->string('secondary_image')->nullable();

            // Publishing / display
            $table->string('status', 20)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);

            // SEO-ready
            $table->string('seo_title', 160)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('og_image')->nullable();

            $table->timestamps();

            $table->index(['status', 'sort_order']);
            $table->index(['status', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

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
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('problem')->nullable();
            $table->json('what_i_built')->nullable();
            $table->json('key_features')->nullable();
            $table->json('tech_stack')->nullable();
            $table->json('my_role')->nullable();
            $table->string('live_demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('outcome')->nullable();
            $table->boolean('is_public_github')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

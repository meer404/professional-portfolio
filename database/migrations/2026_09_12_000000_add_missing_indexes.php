<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('read_at');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index('featured');
            $table->index('sort_order');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['read_at']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['featured']);
            $table->dropIndex(['sort_order']);
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
        });
    }
};

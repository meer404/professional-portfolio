<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('category');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('proficiency');
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->unsignedTinyInteger('proficiency')->nullable()->after('category');
            $table->dropColumn('icon');
        });
    }
};

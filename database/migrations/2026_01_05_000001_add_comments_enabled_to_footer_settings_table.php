<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('footer_settings') && !Schema::hasColumn('footer_settings', 'comments_enabled')) {
            Schema::table('footer_settings', function (Blueprint $table) {
                $table->boolean('comments_enabled')->default(true)->after('related_links');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('footer_settings') && Schema::hasColumn('footer_settings', 'comments_enabled')) {
            Schema::table('footer_settings', function (Blueprint $table) {
                $table->dropColumn('comments_enabled');
            });
        }
    }
};

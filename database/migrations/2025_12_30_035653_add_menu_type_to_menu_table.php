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
        Schema::table('menu', function (Blueprint $table) {
            $table->enum('menu_type', ['group', 'link'])->default('link')->after('nama_menu');
            
            $table->string('link_type', 50)->nullable()->change();
            $table->unsignedBigInteger('page_id')->nullable()->change();
            $table->string('url_halaman', 255)->nullable()->change();
            
            $table->index('menu_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropIndex(['menu_type']);
            $table->dropColumn('menu_type');
            
        });
    }
};

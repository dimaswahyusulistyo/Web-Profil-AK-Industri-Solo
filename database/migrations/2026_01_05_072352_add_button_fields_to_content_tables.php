<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public static function up_table(string $tableName): void
    {
        Schema::table($tableName, function (Blueprint $table) {
            $table->string('button_text')->nullable()->after('konten');
            $table->string('button_url')->nullable()->after('button_text');
        });
    }

    public static function down_table(string $tableName): void
    {
        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_url']);
        });
    }

    public function up(): void
    {
        $this->up_table('pengumuman');
        $this->up_table('konten_biasa');
    }

    public function down(): void
    {
        $this->down_table('pengumuman');
        $this->down_table('konten_biasa');
    }
};

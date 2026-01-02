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
        Schema::table('aspirasi_aduan', function (Blueprint $table) {
            if (!Schema::hasColumn('aspirasi_aduan', 'no_telp')) {
                $table->string('no_telp')->after('email');
            }
            if (!Schema::hasColumn('aspirasi_aduan', 'kategori_aduan_id')) {
                $table->foreignId('kategori_aduan_id')->after('no_telp')->constrained('kategori_aduans');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasi_aduan', function (Blueprint $table) {
            if (Schema::hasColumn('aspirasi_aduan', 'no_telp')) {
                $table->dropColumn('no_telp');
            }
            if (Schema::hasColumn('aspirasi_aduan', 'kategori_aduan_id')) {
                $table->dropForeign(['kategori_aduan_id']);
                $table->dropColumn('kategori_aduan_id');
            }
        });
    }
};

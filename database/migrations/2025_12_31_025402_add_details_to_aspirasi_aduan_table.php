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
            $table->string('no_telp')->after('email')->nullable();
            $table->foreignId('kategori_aduan_id')->after('no_telp')->nullable()->constrained('kategori_aduans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasi_aduan', function (Blueprint $table) {
            //
        });
    }
};

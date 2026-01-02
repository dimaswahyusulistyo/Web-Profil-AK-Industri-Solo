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
        $pengumumans = \App\Models\Pengumuman::whereNull('url_halaman')->orWhere('url_halaman', '')->get();
        
        foreach ($pengumumans as $p) {
            $p->update([
                'url_halaman' => \Illuminate\Support\Str::slug($p->judul) . '-' . $p->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

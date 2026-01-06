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
        // 1. Konten Biasa
        Schema::table('konten_biasa', function (Blueprint $table) {
            $table->json('buttons')->nullable()->after('button_url');
            $table->json('embeds')->nullable()->after('embed_url');
        });

        // Migrate existing data for Konten Biasa
        \DB::table('konten_biasa')->get()->each(function ($item) {
            $buttons = [];
            if ($item->button_text || $item->button_url) {
                $buttons[] = [
                    'text' => $item->button_text,
                    'url' => $item->button_url ?? '#',
                ];
            }

            $embeds = [];
            if ($item->embed_url) {
                $embeds[] = [
                    'url' => $item->embed_url,
                    'description' => 'Embed'
                ];
            }

            \DB::table('konten_biasa')
                ->where('id', $item->id)
                ->update([
                    'buttons' => count($buttons) > 0 ? json_encode($buttons) : null,
                    'embeds' => count($embeds) > 0 ? json_encode($embeds) : null,
                ]);
        });

        Schema::table('konten_biasa', function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_url', 'embed_url']);
        });

        // 2. Pengumuman
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->json('buttons')->nullable()->after('button_url');
        });

        // Migrate existing data for Pengumuman
        \DB::table('pengumuman')->get()->each(function ($item) {
            $buttons = [];
            if ($item->button_text || $item->button_url) {
                $buttons[] = [
                    'text' => $item->button_text,
                    'url' => $item->button_url ?? '#',
                ];
            }

            \DB::table('pengumuman')
                ->where('id', $item->id)
                ->update([
                    'buttons' => count($buttons) > 0 ? json_encode($buttons) : null,
                ]);
        });

        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse Konten Biasa
        Schema::table('konten_biasa', function (Blueprint $table) {
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('embed_url')->nullable();
        });

        // Restore first item from JSON (lossy)
        \DB::table('konten_biasa')->get()->each(function ($item) {
            $buttons = json_decode($item->buttons, true);
            $embeds = json_decode($item->embeds, true);

            \DB::table('konten_biasa')
                ->where('id', $item->id)
                ->update([
                    'button_text' => $buttons[0]['text'] ?? null,
                    'button_url' => $buttons[0]['url'] ?? null,
                    'embed_url' => $embeds[0]['url'] ?? null,
                ]);
        });

        Schema::table('konten_biasa', function (Blueprint $table) {
            $table->dropColumn(['buttons', 'embeds']);
        });

        // Reverse Pengumuman
        Schema::table('pengumuman', function (Blueprint $table) {
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
        });

        \DB::table('pengumuman')->get()->each(function ($item) {
            $buttons = json_decode($item->buttons, true);

            \DB::table('pengumuman')
                ->where('id', $item->id)
                ->update([
                    'button_text' => $buttons[0]['text'] ?? null,
                    'button_url' => $buttons[0]['url'] ?? null,
                ]);
        });

        Schema::table('pengumuman', function (Blueprint $table) {
            $table->dropColumn('buttons');
        });
    }
};

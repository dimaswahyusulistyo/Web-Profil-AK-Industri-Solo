<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------
        | PAGES (HALAMAN)
        |--------------------------------------------------
        */
        Schema::create('konten_biasa', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('url_halaman')->unique();
            $table->longText('konten')->nullable();
            $table->string('embed_url')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | MENUS (MENU & SUB MENU)
        |--------------------------------------------------
        */
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('menu')
                ->nullOnDelete();

            $table->enum('link_type', [
                'home',
                'konten_biasa',
                'berita_list',
                'pengumuman_list',
            ]);

            $table->foreignId('page_id')
                ->nullable()
                ->constrained('konten_biasa')
                ->nullOnDelete();

            $table->string('url_halaman')->nullable();
            $table->integer('urutan')->default(0);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | SLIDERS (HOME)
        |--------------------------------------------------
        */
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar');
            $table->string('url')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | SERVICES (LAYANAN / SHORTCUT HOME)
        |--------------------------------------------------
        */
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('ikon')->nullable();
            $table->string('tautan');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | NEWS CATEGORIES (KATEGORI BERITA)
        |--------------------------------------------------
        */
        Schema::create('kategori_berita', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('url_halaman')->unique();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | NEWS (BERITA)
        |--------------------------------------------------
        */
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('url_halaman')->unique();
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->constrained('kategori_berita')
                  ->nullOnDelete();
            $table->longText('konten');
            $table->string('thumbnail');
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | ANNOUNCEMENTS (PENGUMUMAN)
        |--------------------------------------------------
        */
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('thumbnail');
            $table->longText('konten');
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | PARTNERS (MITRA)
        |--------------------------------------------------
        */
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | COMMENTS (KOMENTAR - POLYMORPHIC)
        |--------------------------------------------------
        */
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->longText('isi_komentar');
            $table->string('commentable_type');
            $table->unsignedBigInteger('commentable_id');
            $table->longText('tanggapan')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['commentable_type', 'commentable_id']);
        });

        /*
        |--------------------------------------------------
        | COMPLAINTS (ASPIRASI & ADUAN)
        |--------------------------------------------------
        */
        Schema::create('aspirasi_aduan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->longText('pesan');
            $table->longText('tanggapan')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | ROLES
        |--------------------------------------------------
        */
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_role');
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('aspirasi_aduan');
        Schema::dropIfExists('komentar');
        Schema::dropIfExists('mitra');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('berita');
        Schema::dropIfExists('kategori_berita');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('konten_biasa');
    }
};

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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('layout');
            $table->longText('konten')->nullable();
            $table->json('konfigurasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | MENUS (MENU & SUB MENU)
        |--------------------------------------------------
        */
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu');
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('menus')
                  ->nullOnDelete();
            $table->enum('tipe', ['halaman', 'list', 'url']);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('url')->nullable();
            $table->enum('posisi', ['header', 'footer'])->default('header');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | SLIDERS (HOME)
        |--------------------------------------------------
        */
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('gambar');
            $table->string('tautan')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | SERVICES (LAYANAN / SHORTCUT HOME)
        |--------------------------------------------------
        */
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('ikon')->nullable();
            $table->string('tautan');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | NEWS CATEGORIES (KATEGORI BERITA)
        |--------------------------------------------------
        */
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('slug')->unique();
        });

        /*
        |--------------------------------------------------
        | NEWS (BERITA)
        |--------------------------------------------------
        */
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('news_categories')
                  ->nullOnDelete();
            $table->longText('konten');
            $table->string('thumbnail')->nullable();
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | ANNOUNCEMENTS (PENGUMUMAN)
        |--------------------------------------------------
        */
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('konten');
            $table->string('lampiran')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | PARTNERS (MITRA)
        |--------------------------------------------------
        */
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra');
            $table->string('logo');
            $table->string('website')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------
        | COMMENTS (KOMENTAR - POLYMORPHIC)
        |--------------------------------------------------
        */
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->longText('isi_komentar');
            $table->string('commentable_type');
            $table->unsignedBigInteger('commentable_id');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['commentable_type', 'commentable_id']);
        });

        /*
        |--------------------------------------------------
        | COMPLAINTS (ASPIRASI & ADUAN)
        |--------------------------------------------------
        */
        Schema::create('complaints', function (Blueprint $table) {
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
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_categories');
        Schema::dropIfExists('services');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('pages');
    }
};

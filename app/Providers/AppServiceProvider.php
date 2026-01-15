<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
use App\Models\FooterSetting;
use App\Models\Pengumuman;
use App\Models\Layanan;
use App\Models\Slider;
use App\Models\Menu;
use App\Models\Mitra;
use App\Models\Komentar;
use App\Models\AspirasiAduan;
use App\Models\KategoriAduan;
use App\Models\KontenBiasa;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Policies\RestrictedPolicy;
use App\Policies\BeritaPolicy;
use App\Policies\KontenBiasaPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, RestrictedPolicy::class);
        Gate::policy(Role::class, RestrictedPolicy::class);
        Gate::policy(FooterSetting::class, RestrictedPolicy::class);
        Gate::policy(Pengumuman::class, RestrictedPolicy::class);
        Gate::policy(Layanan::class, RestrictedPolicy::class);
        Gate::policy(Slider::class, RestrictedPolicy::class);
        Gate::policy(Menu::class, RestrictedPolicy::class);
        Gate::policy(Mitra::class, RestrictedPolicy::class);
        Gate::policy(Komentar::class, RestrictedPolicy::class);
        Gate::policy(AspirasiAduan::class, RestrictedPolicy::class);
        Gate::policy(KategoriAduan::class, RestrictedPolicy::class);
        Gate::policy(KontenBiasa::class, KontenBiasaPolicy::class);

        Gate::policy(Berita::class, BeritaPolicy::class);
        Gate::policy(KategoriBerita::class, BeritaPolicy::class);
    }
}

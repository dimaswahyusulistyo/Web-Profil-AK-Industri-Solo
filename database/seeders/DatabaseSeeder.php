<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'AK Industri Admin',
            'email' => 'admin.AK@filament.test',
            'password' => Hash::make('jaya2026'),
        ]);

        $role = \App\Models\Role::firstOrCreate(['nama_role' => 'Admin']);
        $user->roles()->attach($role);

        $this->command->info('Admin Filament user created: admin.AK@filament.test / jaya2026');
    }
}
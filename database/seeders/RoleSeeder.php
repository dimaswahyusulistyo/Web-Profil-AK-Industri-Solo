<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['nama_role' => 'Admin']);
        Role::firstOrCreate(['nama_role' => 'Admin Berita']);
    }
}

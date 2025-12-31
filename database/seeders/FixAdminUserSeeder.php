<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class FixAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin.AK@filament.test')->first();
        
        if (!$user) {
            $this->command->error('User admin.AK@filament.test not found!');
            return;
        }

        $role = Role::firstOrCreate(['nama_role' => 'Admin']);
        
        if (!$user->roles()->where('id', $role->id)->exists()) {
            $user->roles()->attach($role);
            $this->command->info('Role Admin attached to user admin.AK@filament.test');
        } else {
            $this->command->info('User already has Admin role');
        }
    }
}

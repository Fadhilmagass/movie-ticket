<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsRole::create(['name' => 'super-admin']);
        ModelsRole::create(['name' => 'admin']);
        ModelsRole::create(['name' => 'user']);
    }
}

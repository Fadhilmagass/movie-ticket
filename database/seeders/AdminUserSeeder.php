<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Memastikan role admin sudah ada
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        // Membuat user admin (Jika belum ada)
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@example.com'
            ],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );

        // Berikan role admin ke user
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        echo "Admin user created successfully! Email: admin@example.com | Password: password123\n";
    }
}

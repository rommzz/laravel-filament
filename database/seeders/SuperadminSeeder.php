<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user (atau ambil user jika sudah ada)
        $user = User::firstOrCreate(
            // ['email' => 'admin@email.com'],
            [
                'email' => 'admin@email.com',
                'name' => 'Admin',
                'password' => bcrypt('password'), // Ganti dengan password aman
            ]
        );

        // Buat role super_admin jika belum ada
        // $role = Role::firstOrCreate(['name' => 'super_admin']);

        // $user->assignRole($role);

        $this->command->info('Super admin berhasil dibuat.');
    }
}

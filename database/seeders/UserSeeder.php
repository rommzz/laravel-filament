<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        static::generateDevPermission();
        static::generatePmPermission();
        static::generateUser();
    }

    protected static function generateUser(): void
    {
        $usernames = ['admin', 'amas_dev', 'aan_pm', 'budi_dev', 'cici_pm'];

        $bulkUsers = collect($usernames)->map(function ($username) {
            return [
                'email' => "{$username}@email.com",
                'name' => ucfirst($username),
                'password' => bcrypt('password'),
            ];
        })->toArray();

        DB::table('users')->insert($bulkUsers);

        // Ambil semua user setelah insert
        $users = User::whereIn('email', collect($usernames)->map(fn($u) => "{$u}@email.com"))->get()->keyBy('email');

        // Buat role dan permission super_admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // Assign role ke admin
        $users['admin@email.com']->assignRole($superAdminRole);

        // Assign role developer
        $developerRole = Role::firstOrCreate(['name' => 'developer']);
        foreach ($users as $email => $user) {
            if (str_ends_with($email, 'dev@email.com')) {
                $user->assignRole($developerRole);
            }
        }

        // Assign role pm
        $pmRole = Role::firstOrCreate(['name' => 'pm']);
        foreach ($users as $email => $user) {
            if (str_ends_with($email, 'pm@email.com')) {
                $user->assignRole($pmRole);
            }
        }
    }


    protected static function generateDevPermission(): void {
        $superAdmin = Role::firstOrCreate([
            'name' => 'developer',
            'guard_name' => 'web',
        ]);

        $permissions = [
            // Project
            'view_project',
            'view_any_project',
            'update_project',

            // Task
            'view_task',
            'view_any_task',
            'create_task',
            'update_task',
            'delete_task',
            'delete_any_task',
            'restore_task',
            'restore_any_task',
            'replicate_task',
            'reorder_task',
            'force_delete_task',
            'force_delete_any_task',

            // Subtask
            'view_subtask',
            'view_any_subtask',
            'create_subtask',
            'update_subtask',
            'delete_subtask',
            'delete_any_subtask',
            'restore_subtask',
            'restore_any_subtask',
            'replicate_subtask',
            'reorder_subtask',
            'force_delete_subtask',
            'force_delete_any_subtask',
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            // Beri permission ke super admin
            if (! $superAdmin->hasPermissionTo($permission)) {
                $superAdmin->givePermissionTo($permission);
            }
        }
    }

    protected static function generatePmPermission(): void {
        $superAdmin = Role::firstOrCreate([
            'name' => 'pm',
            'guard_name' => 'web',
        ]);

        $permissions = [
            // Project
            'view_project',
            'view_any_project',
            'create_project',
            'update_project',
            'delete_project',
            'delete_any_project',
            'restore_project',
            'restore_any_project',
            'replicate_project',
            'reorder_project',
            'force_delete_project',
            'force_delete_any_project',

            // task
            'view_task',
            'view_any_task',

            // Subtask
            'view_subtask',
            'view_any_subtask',
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            // Beri permission ke super admin
            if (! $superAdmin->hasPermissionTo($permission)) {
                $superAdmin->givePermissionTo($permission);
            }
        }
    }
}

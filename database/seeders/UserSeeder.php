<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();

        $adminRoleId = Role::where('role_name', 'admin')->value('id');
        $bloggerRoleId = Role::where('role_name', 'blogger')->value('id');

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRoleId,
        ]);

        User::create([
            'name' => 'blogger',
            'email' => 'blogger@example.com',
            'password' => Hash::make('password'),
            'role_id' => $bloggerRoleId,
        ]);

        User::create([
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role_id' => $bloggerRoleId,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

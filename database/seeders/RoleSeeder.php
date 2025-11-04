<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            [ 'role_name' => 'admin' ],
            [ 'role_name' => 'blogger' ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

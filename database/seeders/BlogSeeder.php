<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('blogs')->truncate();

        Blog::factory()
            ->count(100)
            ->create();
    }
}

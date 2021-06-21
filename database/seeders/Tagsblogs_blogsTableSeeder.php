<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Tagsblogs_blogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tagsblogs_blogs::factory(10)->create();
    }
}

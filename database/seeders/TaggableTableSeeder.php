<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaggableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Taggable::factory(10)->create();
    }
}

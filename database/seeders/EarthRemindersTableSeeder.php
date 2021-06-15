<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EarthRemindersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\EarthReminders::factory(5)->create();
    }
}

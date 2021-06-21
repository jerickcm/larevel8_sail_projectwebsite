<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagsblogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('tagsblogs')->insert([
            'name' => 'Google',
            'created_at' =>  $now,
            'updated_at' =>  $now,
        ]);

        DB::table('tagsblogs')->insert([
            'name' => 'Cloud',
            'created_at' =>  $now,
            'updated_at' =>  $now,
        ]);

        DB::table('tagsblogs')->insert([
            'name' => 'PHP',
            'created_at' =>  $now,
            'updated_at' =>  $now,
        ]);

        DB::table('tagsblogs')->insert([
            'name' => 'Nuxt',
            'created_at' =>  $now,
            'updated_at' =>  $now,
        ]);
    }
}

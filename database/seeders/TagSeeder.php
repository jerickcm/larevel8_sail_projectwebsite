<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now = Carbon::now();
        DB::table('tags')->insert([
          'name' => 'Science',
          'created_at' =>  $now ,
          'updated_at' =>  $now ,
        ]);
        $now = Carbon::now();
        DB::table('tags')->insert([
          'name' => 'Culture',
          'created_at' =>  $now ,
          'updated_at' =>  $now ,
        ]);
        $now = Carbon::now();
        DB::table('tags')->insert([
          'name' => 'Sports',
          'created_at' =>  $now ,
          'updated_at' =>  $now ,
        ]);
        $now = Carbon::now();
        DB::table('tags')->insert([
          'name' => 'Events',
          'created_at' =>  $now ,
          'updated_at' =>  $now ,
        ]);
    }
}

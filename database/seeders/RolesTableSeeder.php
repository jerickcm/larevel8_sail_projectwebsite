<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Role::factory(10)->create();

          $now = Carbon::now();
          DB::table('roles')->insert([
            'name' => 'Admin',
            'created_at' =>  $now ,
            'updated_at' =>  $now ,
          ]);
          $now = Carbon::now();
          DB::table('roles')->insert([
            'name' => 'Crm',
            'created_at' =>  $now ,
            'updated_at' =>  $now ,
          ]);
          $now = Carbon::now();
          DB::table('roles')->insert([
            'name' => 'Owner',
            'created_at' =>  $now ,
            'updated_at' =>  $now ,
          ]);
          $now = Carbon::now();
          DB::table('roles')->insert([
            'name' => 'Editor',
            'created_at' =>  $now ,
            'updated_at' =>  $now ,
          ]);

    }
}

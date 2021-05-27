<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Roles_UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Roles_Users::factory(10)->create();
        for ($x = 1; $x <= 10; $x++) {
            $now = Carbon::now();
            DB::table('role_user')->insert([
              'user_id' => $x,
              'role_id' => 1,
              'created_at' =>  $now ,
              'updated_at' =>  $now ,
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($x = 1; $x <= 10; $x++) {
            $faker_users = \App\Models\User::factory(1)->create();
            \App\Models\UserDetails::factory(1)->create([
                'user_id' => $faker_users[0]->id,
            ]);
        }


        // DB::table('users')->insert([
        //     'name' => str_random(10),
        //     'email' => str_random(10).'@test.com'),
        //     'password' => bcrypt('secret')
        // ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            PostTableSeeder::class,
            UsersTableSeeder::class,
            Roles_UsersTableSeeder::class,
            RolesTableSeeder::class,
            StaffTableSeeder::class,
            ProductTableSeeder::class,
            TagSeeder::class,
            VideoSeeder::class,
            TaggableTableSeeder::class,
            MessageoftheDayTableSeeder::class,
            BlogTableSeeder::class,
            EarthRemindersTableSeeder::class,
        ]);
    }
}

// randomDigit             // 7
// randomDigitNot(5)       // 0, 1, 2, 3, 4, 6, 7, 8, or 9
// randomDigitNotNull      // 5
// randomNumber($nbDigits = NULL, $strict = false) // 79907610
// randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL) // 48.8932
// numberBetween($min = 1000, $max = 9000) // 8567
// randomLetter            // 'b'
// // returns randomly ordered subsequence of a provided array
// randomElements($array = array ('a','b','c'), $count = 1) // array('c')
// randomElement($array = array ('a','b','c')) // 'b'
// shuffle('hello, world') // 'rlo,h eoldlw'
// shuffle(array(1, 2, 3)) // array(2, 1, 3)
// numerify('Hello ###') // 'Hello 609'
// lexify('Hello ???') // 'Hello wgt'
// bothify('Hello ##??') // 'Hello 42jz'
// asciify('Hello ***') // 'Hello R6+'
// regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'); // sm0@y8k96a.ej

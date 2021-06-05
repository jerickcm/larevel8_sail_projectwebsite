<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageoftheDayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $json  = '[
            {"message": "Code daily to progress.", "author": "coderzero8"},
            {"message": "Life is not fair; get used to it", "author": "Bill Gates"},
            {"message": "The basis of our partnership strategy and our partnership approach: We build the social technology. They provide the music.", "author": "Mark Zuckerberg"},
            {"message": "If you\'re changing the world, you\'re working on important things. You\'re excited to get up in the morning.", "author": "Larry Page"},
            {"message": "Innovation distinguishes between a leader and a follower.", "author": "Steve Jobs"},
            {"message": "Too many rules stifle innovation.", "author": "Sergey Brin"},
            {"message": "Talk is cheap. Show me the code.", "author": "Linus Torvalds"}
        ]';

        $array = json_decode($json, true);

        foreach ($array as $item) {

            $now = Carbon::now();
            DB::table('messageoftheday')->insert([
                'message' => $item['message'],
                'author' => $item['author'],
                'user_id' => 1,
                'created_at' =>  $now,
                'updated_at' =>  $now,
            ]);
        }
    }
}

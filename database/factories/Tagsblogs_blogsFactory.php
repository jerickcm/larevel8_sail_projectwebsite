<?php

namespace Database\Factories;

use App\Models\Tagsblogs_blogs;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class Tagsblogs_blogsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tagsblogs_blogs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = Carbon::now();
        return [
            'blog_id' => rand(1, 10),
            'tagsblogs_id' => rand(1, 4),
            'created_at' =>  $now,
            'updated_at' =>  $now
        ];
    }
}

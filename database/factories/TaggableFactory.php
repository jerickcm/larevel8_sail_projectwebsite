<?php

namespace Database\Factories;

use App\Models\Taggable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class TaggableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taggable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = Carbon::now();
        return [
            'tag_id' => rand(1,4),
            'taggable_id' => rand(1,10),
            'taggable_type' => $this->faker->randomElement(['App\Models\Video', 'App\Models\Post',]),
            'created_at' =>  $now ,
            'updated_at' =>  $now
        ];
    }
}

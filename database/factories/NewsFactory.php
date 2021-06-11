<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $publish = rand(1, 2);
        return [
            'title' => $title = $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'slug' => Str::slug($title),
            'publish' =>  $publish,
            'publish_text' => ($publish == 1) ? 'draft' : 'publish',
            'name' =>  $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            'content' =>  $this->faker->sentence($nbWords = 7, $variableNbWords = true),
            'user_id' => rand(1, 10),
        ];
    }
}

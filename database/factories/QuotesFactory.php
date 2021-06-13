<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Quotes;

class QuotesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quotes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $publish = rand(1, 2);
        return [
            'author' =>  $this->faker->name(),
            'message' => $this->faker->sentence($nbWords = 3, $variableNbWords = true),
            'publish' =>  $publish,
            'publish_text' => ($publish == 1) ? 'draft' : 'publish',
            'user_id' => rand(1, 10),
        ];
    }
}

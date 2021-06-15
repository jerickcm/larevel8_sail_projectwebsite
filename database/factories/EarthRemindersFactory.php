<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EarthReminders;
class EarthRemindersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EarthReminders::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $publish = rand(1, 2);
        return [
            'title' => $title = $this->faker->catchPhrase,
            'subtitle' => $this->faker->catchPhrase,
            'slug' => Str::slug($title),
            'publish' =>  $publish,
            'country' => $this->faker->countryCode,
            'content' =>  $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'event_date' =>  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'publish_text' => ($publish == 1) ? 'draft' : 'publish',
            'user_id' => rand(1, 10),
        ];
    }
}

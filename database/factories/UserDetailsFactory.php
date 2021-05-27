<?php

namespace Database\Factories;

use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'house_number' => $this->faker->buildingNumber(),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->streetAddress(),
            'province' =>  $this->faker->state(),
            'country' =>  $this->faker->country(),
            'postcode' =>  $this->faker->postcode(),
        ];
    }
}

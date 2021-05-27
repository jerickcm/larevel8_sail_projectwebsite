<?php

namespace Database\Factories;

use App\Models\Roles_Users;
use Illuminate\Database\Eloquent\Factories\Factory;

class Roles_UsersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Roles_Users::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1,10),
            'role_id' => rand(1,4),
        ];
    }
}

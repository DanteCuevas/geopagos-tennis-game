<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male' , 'female']);
        $first_name = $gender === 'male' ? $this->faker->firstNameMale() : $this->faker->firstNameFemale();

        return [
            'first_name'    => $first_name,
            'last_name'     => $this->faker->lastName(),
            'gender'        => $gender,
            'skill'         => $this->faker->numberBetween(0, 100),
            'strength'      => $this->faker->numberBetween(0, 100),
            'speed'         => $this->faker->numberBetween(0, 100),
            'reaction'      => $this->faker->numberBetween(0, 100)
        ];
    }

    public function male()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name'    => $this->faker->firstNameMale(),
                'gender'        => 'male',
            ];
        });
    }

    public function female()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name'    => $this->faker->firstNameFemale(),
                'gender'        => 'female',
            ];
        });
    }
}

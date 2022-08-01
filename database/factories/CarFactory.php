<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $trademark = array("a" => "Honda", "b" => "Chevrolet", "c" => "Nissan", 'd' => 'Volkswagen');

        return [
            'name'      => $this->faker->domainWord,
            'price'     => $this->faker->numberBetween(50000, 500000),
            'trademark' => $trademark[array_rand($trademark)],
            'year'      => $this->faker->year('now'),
            'sold'      => $this->faker->boolean(30),
        ];
    }
}

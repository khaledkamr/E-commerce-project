<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        return [
            'name' => $name,
        ];
    }
}

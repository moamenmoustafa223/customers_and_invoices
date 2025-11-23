<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{


    protected $model = Car::class;



    public function definition()
    {
        return [
            "user_id" => '1',
            "customer_id" => $this->faker->numberBetween(1,5),
            "model" => $this->faker->name(),
            "car_color" => $this->faker->colorName(),
            "country_manufacture" => $this->faker->century(),
            "manufacturing_year" => $this->numberBetween(1990,2000),
            "cylinders_no" => $this->faker->numberBetween(2500,5000),
            "registration_no" => $this->faker->numberBetween(10000,500000),
            "car_no" => $this->faker->numberBetween(10000,500000),
        ];
    }
}

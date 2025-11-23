<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{


    protected $model = Service::class;



    public function definition()
    {
        return [
            "user_id" => '1',
            "image" => 'images/no_image.png',
            "name_ar" => $this->faker->name(),
            "name_en" => $this->faker->name(),
            "price" => $this->faker->numberBetween(10,100),
        ];
    }
}

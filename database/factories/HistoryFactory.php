<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use App\Client;
use App\History;
use Faker\Generator as Faker;

$factory->define(History::class, function (Faker $faker) {
    return [
        'client_id' => Client::all()->random()->id,
        'car_id' => Car::all()->random()->id,
        'type' => $faker->randomElement(['buy', 'trade']),
        'payed' => $faker->randomFloat(3, $min = 2500.000, $max = 250000.000)
    ];
});

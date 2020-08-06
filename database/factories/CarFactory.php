<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

$brands = json_decode(File::get(base_path() . '/database/data/cars_brands.json'));

$factory->define(Car::class, function (Faker $faker) use ($brands) {
    return [
        'brand' => $faker->randomElement($brands),
        'class' => $faker->randomElement(['A','B','C','D','E','F']),
        'model' => Str::title($faker->words(2, true)),
        'price' => $faker->randomFloat(3, $min = 5000.000, $max = 500000.000)
    ];
});

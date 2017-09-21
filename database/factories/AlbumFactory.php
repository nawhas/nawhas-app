<?php

use App\User;
use App\Reciter;
use App\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'reciter_id' => Reciter::all()->random()->id,
        'year' => $faker->year(),
        'artwork' => $faker->imageUrl(640, 480, 'people'),
        'status' => 0,
        'created_by' => User::all()->random()->id,
    ];
});

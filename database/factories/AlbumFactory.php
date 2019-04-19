<?php

use App\Reciter;
use App\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'reciter_id' => function () {
            return factory(Reciter::class)->create()->id;
        },
        'year' => $faker->year(),
        'artwork' => $faker->imageUrl(640, 480, 'people'),
        'created_by' => 1,
    ];
});

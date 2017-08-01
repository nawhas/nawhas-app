<?php

use App\Reciter;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reciter::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->name,
        'slug' => str_slug($name),
        'description' => $faker->paragraph,
        'hits' => $faker->randomNumber(3),
        'image_path' => $faker->imageUrl(640, 480, 'people'),
        'status' => 0,
        'created_by' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});

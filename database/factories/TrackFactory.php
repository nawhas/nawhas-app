<?php

use App\User;
use App\Reciter;
use App\Album;
use App\Track;
use Faker\Generator as Faker;

$factory->define(Track::class, function (Faker $faker) {
    return [
    	'name' => $name = $faker->name,
    	'slug' => str_slug($name),
    	'reciter_id' => function () {
            return factory(Reciter::class)->create();
        },
    	'album_id' => function () {
            return factory(Album::class)->create();
        },
        'video' => $faker->imageUrl(640, 480, 'people'),
        'audio' => $faker->imageUrl(640, 480, 'people'),
        'number' => $faker->randomDigit,
        'created_by' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

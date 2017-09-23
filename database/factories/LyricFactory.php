<?php

use App\User;
use App\Track;
use App\Lyric;
use Faker\Generator as Faker;

$factory->define(Lyric::class, function (Faker $faker) {
    return [
        'text' => $faker->text,
        'track_id' => function () {
            return factory(Track::class)->create()->id;
        },
        'created_by' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

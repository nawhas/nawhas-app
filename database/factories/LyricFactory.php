<?php

use App\User;
use App\Reciter;
use App\Album;
use App\Track;
use App\Lyric;
use Faker\Generator as Faker;

$factory->define(Lyric::class, function (Faker $faker) {
    return [
    	'text' => $faker->text,
    	'track_id' => Track::all()->random()->id,
        'created_by' => User::all()->random()->id,
    ];
});

<?php

use App\User;
use App\Reciter;
use App\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
	$user = factory(User::class)->create();
	$reciter = factory(Reciter::class)->create();
    return [
        'name' => $name = $faker->name,
        'reciter_id' => $reciter->id,
        'year' => $faker->year(),
        'artwork' => $faker->imageUrl(640, 480, 'people'),
        'created_by' => $user->id,
    ];
});

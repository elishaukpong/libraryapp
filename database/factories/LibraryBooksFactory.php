<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LibraryBooks::class, function (Faker $faker) {
    return [
    'name' => $faker->name,
    'description' => $faker->sentence,
    'slug' => str_slug($faker->name),
    'avatar' => $faker->image('storage/app/public/avatars', 400, 400, null, false),
    'availableCopies' => $faker->numberBetween(10, 25),
    'borrowedCopies' => $faker->numberBetween(0, 8),
    ];
});


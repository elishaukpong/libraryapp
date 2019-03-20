<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Library::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'location' => $faker->address,
        'email' => $faker->email,
        'slug' => str_slug($faker->name),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Library::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'location' => $faker->address,
        'email' => $faker->email,
        'library_id' =>  str_random(2) . rand(10, 90),
        'slug' => str_slug($faker->name),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LibrarySection::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => str_slug($faker->name),
    ];
});

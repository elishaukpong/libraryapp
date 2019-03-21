<?php

use Faker\Generator as Faker;

$factory->define(App\Models\LibrarySection::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => str_slug($faker->name),
        'section_id' => str_random(3) . rand(10, 90),
    ];
});

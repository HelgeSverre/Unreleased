<?php

use Faker\Generator as Faker;

$factory->define(\App\Artist::class, function (Faker $faker) {
    return [
        "stage_name" => $faker->name,
        "real_name" => $faker->name,
        "bio" => $faker->text

    ];
});

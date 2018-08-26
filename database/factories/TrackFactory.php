<?php

use Faker\Generator as Faker;

$factory->define(\App\Track::class, function (Faker $faker) {
    return [
        "genre_id" => function () {
            return factory(\App\Genre::class)->create()->id;
        },
        "artist_id" => function () {
            return factory(\App\Artist ::class)->create()->id;
        },
        'title' => 'New track',
        'source_url' => 'https://example.com',
        'source_description' => 'Description of Source'
    ];
});

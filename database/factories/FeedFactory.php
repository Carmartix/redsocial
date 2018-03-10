<?php

use Faker\Generator as Faker;

$factory->define(App\Feed::class, function (Faker $faker) {
    return [
        'content' => $faker->realText,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'likes' => $faker->randomNumber(3),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        "created_at" => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = 'America/Caracas')
    ];
});

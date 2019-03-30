<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(15),
        'body' => $faker->text(200),
        'author' => $faker->name()
    ];
});

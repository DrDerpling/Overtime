<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Overtime::class, function (Faker $faker) {
    return [
        'hours' => $faker->numberBetween(1, 3),
        'description' => $faker->text('50'),
    ];
});

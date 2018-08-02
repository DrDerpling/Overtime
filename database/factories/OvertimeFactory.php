<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Overtime::class, function (Faker $faker) {
    $paid = $faker->boolean(20);
    $off = $paid ? $faker->boolean(20) : false;
    return [
        'hours' => $faker->numberBetween(1, 3),
        'description' => $faker->text('50'),
        'off_time'  => $off,
        'paid_out'  => $paid
    ];
});

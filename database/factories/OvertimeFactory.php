<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Overtime::class, function (Faker $faker) {
    $rangeOfNumbers = range(0.25, 3, 0.25);
    return [
        'hours' => array_random($rangeOfNumbers),
        'description' => $faker->text('50')
    ];
});

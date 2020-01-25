<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Commons\Contact::class, function (Faker $faker) {
    return [
        'phone' => $faker->areaCode() . $faker->landline(false),
        'cellphone' => $faker->areaCode() . $faker->cellphone(false, true),
    ];
});

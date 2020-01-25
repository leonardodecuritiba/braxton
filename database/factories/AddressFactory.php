<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Commons\Address::class, function (Faker $faker) {
	$state = \App\Models\Commons\CepStates::all()->random(1)->first();
    return [
        'state_id' => $state->id,
        'city_id' => $state->cities->random(1)->first()->id,
        'zip' => $faker->randomNumber($nbDigits = 8),
        'district' => $faker->streetName,
        'street' => $faker->streetName,
        'number' => $faker->randomNumber($nbDigits = 4),
        'complement' => $faker->word
    ];
});

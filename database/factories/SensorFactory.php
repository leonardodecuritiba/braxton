<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Clients\Sensor::class, function (Faker $faker) {
	$magnitude_id = \App\Models\Commons\SensorType::all()->random(1)->first()->id;
	$Device = \App\Models\Clients\Device::all()->random(1)->first();
	return [
		'author_id'     => $Device->client_id,
		'device_id'     => $Device->id,
		'sensor_type_id'  => $magnitude_id,
		'name'          => $faker->text(40),
		'active'        => $faker->boolean(),
	];
});

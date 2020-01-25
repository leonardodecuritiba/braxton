<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Clients\Dashboard::class, function (Faker $faker) {
	$sensor = \App\Models\Clients\Sensor::all()->random(1)->first();
	$period = $faker->numberBetween($min = 0, $max = 4);
	$color  = \App\Helpers\BaseHelper::$_DASHBOARD_COLORS_[$faker->numberBetween($min = 0, $max = 22)];
	$bullet = $faker->numberBetween($min = 0, $max = 4);
	$format = $faker->numberBetween($min = 0, $max = 1);
	return [
		'author_id'     => $sensor->author_id,
		'client_id'     => $sensor->device->client_id,
		'sensor_id'     => $sensor->id,
		'size'          => 0,
		'period'        => $period,
		'color'         => $color,
		'format'        => $format,
		'bullet'        => $bullet,
		'active'        => $faker->boolean(),
	];
});

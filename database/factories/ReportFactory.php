<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Clients\Reports\Report::class, function (Faker $faker) {
	$sensor = \App\Models\Clients\Sensor::all()->random(1)->first();
	$emails = $faker->boolean();

	$repetition = $faker->numberBetween($min = 0, $max = 2);
	$time = [date('H:i', rand(1,54000)), date('H:i', rand(1,54000))];

	switch ($repetition){
		case 0:
			$repetition_option = $faker->numberBetween($min = 1, $max = 28);
			$interval = 3;
			break;
		case 1:
			$repetition_option = $faker->numberBetween($min = 0, $max = 7);
			$interval = 3;
			break;
		case 2:
			$repetition_option = NULL;
			$interval = $faker->numberBetween($min = 0, $max = 2);
			break;

	}

	return [
		'author_id'         => $sensor->author_id,
		'client_id'         => $sensor->device->client_id,
		'sensor_id'         => $sensor->id,
		'name'              => $faker->text(40),
		'repetition'        => $repetition,
		'repetition_option' => $repetition_option,
		'execution_at'      => $faker->dateTime(),
		'interval'          => $interval,
		'time'              => $time,
		'send_email'        => $faker->boolean(),
		'main_email'        => $faker->email,
		'copy_email'        => $emails ? [$faker->email, $faker->email, $faker->email] : NULL,
		'active'            => $faker->boolean(),
	];

});

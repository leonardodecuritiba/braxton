<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Clients\Alerts\Alert::class, function (Faker $faker) {
	$sensor = \App\Models\Clients\Sensor::all()->random(1)->first();
	$emails = $faker->boolean();
	$alert_type = $faker->numberBetween($min = 0, $max = 3);
	$condition_type = ($alert_type == 3) ? $faker->numberBetween($min = 0, $max = 7) : NULL;



	$time = [date('H:i', rand(1,54000)), date('H:i', rand(54000,(54000*2)-1))];
	$days = $faker->randomElements($array = array ('0','1','2','3','4','5','6'), $count = $faker->numberBetween($min = 1, $max = 7));

	$min = $sensor->getMinValue();
	$max = $sensor->getMaxValue();

	$condition_values = NULL;
	switch($alert_type){
		case 0:
		case 1:
			$days = ['0','1','2','3','4','5','6'];
			$time = ['00:00','23:59'];
			break;
		case 2:
			$condition_values = $faker->numberBetween(1, 60);
			break;
		case 3:
			$num = $faker->numberBetween($min, $max);
			$condition_values = ($condition_type > 1) ? $num : implode(',',[$num, $num + 3]);
			break;

	}

	return [
		'author_id'     => $sensor->author_id,
		'client_id'     => $sensor->device->client_id,
		'sensor_id'     => $sensor->id,
		'name'          => $faker->text(40),
		'time'          => $time,
		'days'          => $days,
		'alert_type'    => $alert_type,
		'condition_type'=> $condition_type,
		'condition_values'=> $condition_values,
		'send_email'    => $faker->boolean(),
		'main_email'    => $faker->email,
		'copy_email'    => $emails ? [$faker->email, $faker->email, $faker->email] : NULL,
		'active'        => $faker->boolean(),
	];
});

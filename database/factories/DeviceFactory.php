<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Clients\Device::class, function (Faker $faker) {
	$client = \App\Models\Clients\Client::all()->random(1)->first();
	return [
		'author_id' => $client->id,
		'client_id' => $client->id,
		'name'      => $faker->text(40),
		'content'   => $faker->text(200),
		'active'    => $faker->boolean(),
	];
});

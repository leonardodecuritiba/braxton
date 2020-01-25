<?php

use Faker\Generator as Faker;
use \App\Models\Clients\SubClient;
use \App\Models\Users\User;

$factory->define(SubClient::class, function (Faker $faker) {
	$client = \App\Models\Clients\Client::all()->random(1)->first();
	$user        = factory( User::class )->create();
	$user->attachRole( 3 );
    return [
        'user_id' => $user->id,
        'client_id' => $client->id,
    ];
});
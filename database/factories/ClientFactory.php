<?php

use Faker\Generator as Faker;
use \App\Models\Clients\Client;
use \App\Models\Users\User;

$factory->defineAs( Client::class, 'natural', function ( Faker $faker ) {
	$user = factory( User::class )->create();
	$user->attachRole( 2 );
	return [
		'user_id'    => function () use ( $user ) {
			return $user->id;
		},
		'address_id' => function () {
			return factory( \App\Models\Commons\Address::class )->create()->id;
		},
		'contact_id' => function () {
			return factory( \App\Models\Commons\Contact::class )->create()->id;
		},
		'type'       => 0,
	];
} );

$factory->defineAs( Client::class, 'legal', function ( Faker $faker ) {
	$user        = factory( User::class )->create();
	$user->attachRole( 2 );
	return [
		'user_id'      => function () use ( $user ) {
			return $user->id;
		},
		'address_id'   => function () {
			return factory( \App\Models\Commons\Address::class )->create()->id;
		},
		'contact_id'   => function () {
			return factory( \App\Models\Commons\Contact::class )->create()->id;
		},
		'type'         => 1,
		'fantasy_name' => $faker->company,
		'company_name' => $faker->company,
	];
} );
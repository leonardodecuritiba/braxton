<?php

use Faker\Generator as Faker;
use \App\Models\Admins\Admin;
use \App\Models\Users\User;

$factory->define(Admin::class, function (Faker $faker) {
	$user = factory( User::class )->create();
	$user->attachRole( 1 );
    return [
        'user_id' => $user->id,
        'about' => $faker->text(100)
    ];
});
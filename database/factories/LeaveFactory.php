<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Leave;
use App\Reason;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {
    $organization = factory('App\Organization')->create();
    $user = factory('App\User')->create(['organization_id' => $organization->id ]);
    return [
        'organization_id' => $organization->id,
        'user_id' => $user->id, 
        'reason_id' => Reason::all()->random()->id,
        'description' => $faker->words(20, true), 
        'from' => today(), 
        'to' => today()->addDays( rand(1,5) ), 
    ];
});

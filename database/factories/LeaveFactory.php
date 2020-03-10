<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Leave;
use App\Reason;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {
    return [
        'organization_id' => factory('App\Organization')->create()->id,
        'user_id' => factory('App\User')->create()->id,  
        'reason_id' => Reason::all()->random()->id,
        'description' => $faker->words(20, true), 
        'from' => today(), 
        'until' => today()->addDays( rand(1,5) ), 
    ];
});

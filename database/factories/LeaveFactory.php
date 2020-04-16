<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Leave;
use App\Reason;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {
    return [
        'team_id' => factory('App\Team')->create()->id,
        'user_id' => factory('App\User')->create()->id,  
        'reason_id' => Reason::all()->random()->id,
        'reporter_id' => factory('App\User')->create()->id, 
        'description' => $faker->words(20, true),  
        'from' => $faker->dateTimeBetween('-60 days' , 'now' ), 
        'until' => $faker->dateTimeBetween('now' , '+60 days' ), 
    ];
});

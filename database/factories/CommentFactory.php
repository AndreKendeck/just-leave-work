<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create()->id, 
        'leave_id' => factory('App\Leave')->create()->id, 
        'text' => $faker->words( rand(5,20) , true )
    ];
});

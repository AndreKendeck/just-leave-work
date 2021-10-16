<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'amount' => rand(-100, 100),
        'description' => $faker->words(10, true),
        'user_id' => factory('App\User')->create()->id
    ];
});

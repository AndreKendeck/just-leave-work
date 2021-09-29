<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    $fileType = $faker->mimeType;
    return [
        'file_type' => $fileType, 
        'size' => 100, 
        'name' => $faker->word
    ];
});

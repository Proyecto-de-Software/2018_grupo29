<?php

use App\Patient;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Patient::class, function (Faker $faker) {
    
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birthdate' => $faker->date,
        'place_of_birth' => $faker->city,
        'home' => $faker->streetAddress,
        'has_document' => $faker->boolean,
        'phone_number' => $faker->numberBetween($min = 2210000000, $max = 2219999999),
        'dni_number' => $faker->numberBetween($min = 17000000, $max = 43999999),
        'gender_id' =>$faker->numberBetween($min = 1, $max = 3),
    ];
});

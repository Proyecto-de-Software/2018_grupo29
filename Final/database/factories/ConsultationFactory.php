<?php

use App\Reason;
use App\Consultation;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Consultation::class, function (Faker $faker) {
    
    $reason = Reason::all()->pluck('id')->toArray();
    return [
        'articulation' => $faker->sentence,
        'date' => $faker->date,
        'was_internment' => $faker->boolean,
        'diagnostic' => $faker->sentence,
        'observations' => $faker->sentence,
        'reason_id' => $faker->randomElement($reason),
        'derivation_id' =>$faker->numberBetween($min = 1, $max = 3),
        #Esto puede fallar si es que borro patients.
        'patient_id' =>$faker->numberBetween($min = 1, $max = 3),
    ];
});

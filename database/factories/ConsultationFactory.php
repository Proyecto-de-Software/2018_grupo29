<?php

use App\Consultation;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Consultation::class, function (Faker $faker) {
    
    return [
        'articulation' => $faker->sentence,
        'date' => $faker->date,
        'was_internment?' => $faker->boolean,
        'diagnostic' => $faker->sentence,
        'observations' => $faker->sentence,
        #Esto considera que existen 6 motivos y son del id 1 al id 6.
        'reason_id' => $faker->numberBetween($min = 1, $max = 6),
         #Esto puede fallar si es que borro patients.
        'patient_id' =>$faker->numberBetween($min = 1, $max = 3),
    ];
});

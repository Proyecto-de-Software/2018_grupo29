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
        
        #Esto puede fallar si es que borro patients.
        'patient_id' =>$faker->numberBetween($min = 22, $max = 26),
    ];
});
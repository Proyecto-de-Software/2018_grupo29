<?php

use Illuminate\Database\Seeder;

class ReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reasons')->insert([
            'name' => 'Receta médica',
        ]);
        DB::table('reasons')->insert([
            'name' => 'Control por guardia',
        ]);
        DB::table('reasons')->insert([
            'name' => 'Consulta',
        ]);
        DB::table('reasons')->insert([
            'name' => 'Intento de suicidio',
        ]);
        DB::table('reasons')->insert([
            'name' => 'Interconsulta',
        ]);
        DB::table('reasons')->insert([
            'name' => 'Otro',
        ]);
    }
}

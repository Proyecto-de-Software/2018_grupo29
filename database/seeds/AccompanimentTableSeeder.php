<?php

use Illuminate\Database\Seeder;

class AccompanimentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accompaniments')->insert([
            'name' => 'Familiar cercano',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'Hermanos e hijos',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'Pareja',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'Referentes vinculares',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'Policia',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'SAME',
        ]);
        DB::table('accompaniments')->insert([
            'name' => 'Por sus propios medios',
        ]);
    }
}

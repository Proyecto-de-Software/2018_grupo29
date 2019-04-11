<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            'name' => 'Masculino',
        ]);
        DB::table('genders')->insert([
            'name' => 'Femenino',
        ]);
        DB::table('genders')->insert([
            'name' => 'Otro',
        ]);
    }
}

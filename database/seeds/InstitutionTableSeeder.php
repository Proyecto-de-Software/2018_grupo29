<?php

use Illuminate\Database\Seeder;

class InstitutionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institutions')->insert([
            'name' => 'Hospital de Gonnet',
            'director' => '',
            'phone_number' => '2214710551',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
        ]);
        DB::table('institutions')->insert([
            'name' => 'Hospital Italiano',
            'director' => '',
            'phone_number' => '2214710552',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
        ]);
        DB::table('institutions')->insert([
            'name' => 'Hospital Español',
            'director' => '',
            'phone_number' => '2214845533',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
        ]);
    }
}

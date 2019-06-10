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
            'director' => 'Juan Carlos Marquez',
            'phone_number' => '2214710551',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
            'health_region_id' => 1,
            'address' => 'Calle 19 esquina 508',
        ]);
        DB::table('institutions')->insert([
            'name' => 'Hospital Italiano',
            'director' => 'Emilio Berlusconi',
            'phone_number' => '0221 512-9500',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
            'health_region_id' => 1,
            'address' => 'Calle 51 entre 29 y 30',
        ]);
        DB::table('institutions')->insert([
            'name' => 'Hospital Español',
            'director' => 'Albert Baró',
            'phone_number' => '0221 412-9400',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
            'health_region_id' => 2,
            'address' => 'Calle 9 entre 35 y 36',
        ]);
        DB::table('institutions')->insert([
            'name' => 'Hospital Vasco',
            'director' => 'Carles Arruabarrena',
            'phone_number' => '0221 474-7756',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
            'health_region_id' => 2,
            'address' => 'Camino General Belgrano esquina 483',
        ]);
        DB::table('institutions')->insert([
            'name' => 'Centro Intregral de Salud Tolosa',
            'director' => 'Matias Serrano',
            'phone_number' => '0221 424-7683',
            'x_coordinate' => '-34.8891',
            'y_coordinate' => '-58.0216',
            'institution_type_id' => 1,
            'health_region_id' => 3,
            'address' => 'Calle 3 entre 520 y 521',
        ]);
    }
}

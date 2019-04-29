<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'patients_index',
            'description' => 'Permite acceder al listado de los pacientes',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_show',
            'description' => 'Permite acceder a la información en detalle de un paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_update',
            'description' => 'Permite actualizar la información de un paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_destroy',
            'description' => 'Permite eliminar un paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_new',
            'description' => 'Permite crear un paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_index',
            'description' => 'Permite acceder al listado de los usuarios',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_show',
            'description' => 'Permite acceder a la información en detalle de un usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_update',
            'description' => 'Permite actualizar la información de un usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_destroy',
            'description' => 'Permite eliminar un usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_new',
            'description' => 'Permite crear un usuario',
        ]);
    }
}

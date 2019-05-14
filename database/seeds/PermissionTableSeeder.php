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
        # PERMISOS PARA LOS PACIENTES

        DB::table('permissions')->insert([
            'name' => 'patients_index',
            'description' => 'Permite acceder al listado de los pacientes',
            'display_name' => 'Listado de pacientes',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_show',
            'description' => 'Permite acceder a la información en detalle de un paciente',
            'display_name' => 'Ver detalle de paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_update',
            'description' => 'Permite actualizar la información de un paciente',
            'display_name' => 'Actualizar paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_destroy',
            'description' => 'Permite eliminar un paciente',
            'display_name' => 'Eliminar paciente',
        ]);
        DB::table('permissions')->insert([
            'name' => 'patients_new',
            'description' => 'Permite crear un paciente',
            'display_name' => 'Crear nuevo paciente',
        ]);

        # PERMISOS PARA LOS USUARIOS

        DB::table('permissions')->insert([
            'name' => 'users_index',
            'description' => 'Permite acceder al listado de los usuarios',
            'display_name' => 'Listado de usuarios',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_show',
            'description' => 'Permite acceder a la información en detalle de un usuario',
            'display_name' => 'Ver detalle de usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_update',
            'description' => 'Permite actualizar la información de un usuario',
            'display_name' => 'Actualizar usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_destroy',
            'description' => 'Permite eliminar un usuario',
            'display_name' => 'Eliminar usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'users_new',
            'description' => 'Permite crear un usuario',
            'display_name' => 'Crear nuevo usuario',
        ]);

        # PERMISOS PARA LOS ROLES

        DB::table('permissions')->insert([
            'name' => 'roles_index',
            'description' => 'Permite acceder al listado de los roles',
            'display_name' => 'Listado de roles',
        ]);
        DB::table('permissions')->insert([
            'name' => 'roles_show',
            'description' => 'Permite acceder a la información en detalle de un rol',
            'display_name' => 'Ver detalle de usuario',
        ]);
        DB::table('permissions')->insert([
            'name' => 'roles_update',
            'description' => 'Permite actualizar la información de un rol',
            'display_name' => 'Actualizar roles',
        ]);
        DB::table('permissions')->insert([
            'name' => 'roles_destroy',
            'description' => 'Permite eliminar un rol',
            'display_name' => 'Eliminar un rol',
        ]);
        DB::table('permissions')->insert([
            'name' => 'roles_new',
            'description' => 'Permite crear un rol',
            'display_name' => 'Crear un nuevo rol',
        ]);
    }
}

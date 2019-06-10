<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Administrador',
            'description' => 'Podria hacer todo',
        ]);
        $role = Role::where('name','Administrador')->first();
        $permissions = Permission::all();
        $role->attachPermissions($permissions);
    }
}

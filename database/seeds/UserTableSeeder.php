<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Administrador',
            'last_name' => '1',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'is_active' => TRUE,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Equipo de Guardia',
            'last_name' => '1',
            'email' => 'guardia@guardia.com',
            'username' => 'guardia',
            'is_active' => TRUE,
            'password' => Hash::make('123456'),
        ]);
        DB::table('users')->insert([
            'first_name' => 'Recepcionista',
            'last_name' => '1',
            'email' => 'recepcionista@recepcionista.com',
            'username' => 'recepcionista',
            'is_active' => TRUE,
            'password' => Hash::make('123456'),
        ]);

		$roles = Role::all();
        $user = User::where('email','admin@admin.com')->first();
        $user->roles()->attach($roles);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {  
        $this->call(GenderTableSeeder::class);
		$this->call(PatientTableSeeder::class);
		$this->call(ConsultationTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}

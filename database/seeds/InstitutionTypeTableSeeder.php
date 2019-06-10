<?php

use Illuminate\Database\Seeder;

class InstitutionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institutions_types')->insert([
            'name' => 'Hospital Pediátrico',
        ]);
        DB::table('institutions_types')->insert([
            'name' => 'Hospital Neonatólogo',
        ]);
        DB::table('institutions_types')->insert([
            'name' => 'Comisaría',
        ]);
    }
}

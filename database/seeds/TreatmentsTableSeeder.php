<?php

use Illuminate\Database\Seeder;

class TreatmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('treatments')->insert([
            'name' => 'Mañana',
        ]);
        DB::table('treatments')->insert([
            'name' => 'Tarde',
        ]);
        DB::table('treatments')->insert([
            'name' => 'Noche',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class AccompaniedByTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accompanied_by')->insert([
            'name' => 'Familiar cercano',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'Hermanos e hijos',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'Pareja',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'Referentes vinculares',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'Policia',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'SAME',
        ]);
        DB::table('accompanied_by')->insert([
            'name' => 'Por sus propios medios',
        ]);
    }
}

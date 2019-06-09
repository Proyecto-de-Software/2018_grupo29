<?php

use Illuminate\Database\Seeder;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            'key' => 'pagination',
            'value' => '10',
        ]);
        DB::table('configurations')->insert([
            'key' => 'maintenance',
            'value' => '0',
        ]);
        DB::table('configurations')->insert([
            'key' => 'title',
            'value' => 'Hospital A. Korn'
        ]);
        DB::table('configurations')->insert([
            'key' => 'email',
            'value' => ' RRHH@hospitalkorn.com'
        ]);
    }
}

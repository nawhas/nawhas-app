<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'English',
                'status' => 1,
                'moderated_at' => '2016-10-13 00:00:00',
                'moderated_by' => 1,
                'created_at' => '2016-10-13 00:00:00',
                'updated_at' => '2016-10-13 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Urdu',
                'status' => 1,
                'moderated_at' => '2016-10-13 00:00:00',
                'moderated_by' => 1,
                'created_at' => '2016-10-13 00:00:00',
                'updated_at' => '2016-10-13 00:00:00',
            ),
        ));
        
        
    }
}

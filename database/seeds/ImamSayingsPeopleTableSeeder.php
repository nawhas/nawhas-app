<?php

use Illuminate\Database\Seeder;

class ImamSayingsPeopleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('imam_sayings_people')->delete();
        
        \DB::table('imam_sayings_people')->insert(array (
            0 => 
            array (
                'id' => 1,
                'person' => 'Prophet Muhammad SAWW',
                'created_at' => '2016-10-14 00:00:00',
                'updated_at' => '2016-10-14 00:00:00',
                'status' => 1,
                'moderated_at' => '2016-10-14 00:00:00',
                'moderated_by' => 1,
            ),
        ));
        
        
    }
}

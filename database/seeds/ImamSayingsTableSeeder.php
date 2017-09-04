<?php

use Illuminate\Database\Seeder;

class ImamSayingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('imam_sayings')->delete();
        
        \DB::table('imam_sayings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'text' => '"Hussain is from me and I am from Hussain"',
                'imam' => 1,
                'status' => 1,
                'moderated_at' => NULL,
                'moderated_by' => 1,
                'created_at' => '2016-10-14 09:38:24',
                'updated_at' => '2016-10-14 09:38:24',
            ),
            1 => 
            array (
                'id' => 2,
                'text' => '"Hassan and Hussain are the leaders of the youth of Paradise"',
                'imam' => 1,
                'status' => 1,
                'moderated_at' => NULL,
                'moderated_by' => 1,
                'created_at' => '2016-10-14 09:40:35',
                'updated_at' => '2016-10-14 09:40:35',
            ),
        ));
        
        
    }
}

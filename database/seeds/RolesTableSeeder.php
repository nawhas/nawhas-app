<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'This is an admin account',
                'status' => 1,
                'moderated_at' => '2016-10-13 00:00:00',
                'moderated_by' => 1,
                'created_at' => '2016-10-13 00:00:00',
                'updated_at' => '2016-10-13 00:00:00',
            ),
        ));
        
        
    }
}

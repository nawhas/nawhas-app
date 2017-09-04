<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'edit_users',
                'display_name' => 'Edit Users',
                'description' => 'This permission can edit users',
                'status' => 1,
                'moderated_at' => '2016-10-13 00:00:00',
                'moderated_by' => 1,
                'created_at' => '2016-10-13 00:00:00',
                'updated_at' => '2016-10-13 00:00:00',
            ),
        ));
        
        
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Asif Ali',
                'email' => 'shea786@live.co.uk',
                'password' => '$2y$10$pHX23JE21d05s.Jy8FeSdOzWY.EIXooPIl5g/dwBcz9xmYyr4X6xu',
                'remember_token' => NULL,
                'country' => '',
                'status' => 1,
                'moderated_at' => NULL,
                'moderated_by' => NULL,
                'created_at' => '2016-10-10 16:44:51',
                'updated_at' => '2016-10-10 16:44:51',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Shakir Mustafa Moledina',
                'email' => 'shakirmole@gmail.com',
                'password' => '$2y$10$Yuc1NybfRHDKF3N/IknJgehXFR/a49g7NBb0hd8LU6OLXiVb7bOcO',
                'remember_token' => 'RQ82OldaEVCHL3h9UI8WWkFi8DjgrLbMvQWmGwuoCJq11jQZjeT7rFSU7KSQ',
                'country' => '',
                'status' => 1,
                'moderated_at' => NULL,
                'moderated_by' => 1,
                'created_at' => '2016-10-11 15:07:13',
                'updated_at' => '2016-10-14 12:26:20',
            ),
        ));
        
        
    }
}

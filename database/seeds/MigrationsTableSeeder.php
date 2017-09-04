<?php

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'migration' => '2016_09_15_202828_create_reciters_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'migration' => '2016_09_21_102158_create_tracks_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'migration' => '2016_09_21_102425_create_albums_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'migration' => '2016_09_21_102611_create_tags_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'migration' => '2016_09_21_103922_create_lyrics_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'migration' => '2016_09_21_104050_create_languages_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'migration' => '2016_09_21_104104_create_reciterhits_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'migration' => '2016_09_21_104114_create_albumhits_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'migration' => '2016_09_21_104122_create_trackhits_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'migration' => '2016_09_21_104129_create_taghits_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'migration' => '2016_10_07_222514_create_imam_sayings_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'migration' => '2016_10_09_153934_entrust_setup_tables',
                'batch' => 1,
            ),
            14 => 
            array (
                'migration' => '2016_10_14_082622_create_imam_sayings_people_table',
                'batch' => 2,
            ),
        ));
        
        
    }
}

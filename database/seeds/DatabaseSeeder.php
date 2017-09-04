<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('AlbumhitsTableSeeder');
        $this->call('AlbumsTableSeeder');
        $this->call('ImamSayingsTableSeeder');
        $this->call('ImamSayingsPeopleTableSeeder');
        $this->call('LanguagesTableSeeder');
        $this->call('LyricsTableSeeder');
        $this->call('MigrationsTableSeeder');
        $this->call('PasswordResetsTableSeeder');
        $this->call('ReciterhitsTableSeeder');
        $this->call('RecitersTableSeeder');
        $this->call('TaghitsTableSeeder');
        $this->call('TagsTableSeeder');
        $this->call('TrackhitsTableSeeder');
        $this->call('TracksTableSeeder');
        $this->call('UsersTableSeeder');
    }
}

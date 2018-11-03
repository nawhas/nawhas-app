<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
//            factory(\App\User::class, 50)->create();
//            factory(\App\Reciter::class, 50)->create();
//            factory(\App\Album::class, 50)->create();
//            factory(\App\Track::class, 200)->create();
//            factory(\App\Lyric::class, 200)->create();
        }
        $this->call([
            LanguageSeed::class,
        ]);
    }
}

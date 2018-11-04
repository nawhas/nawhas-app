<?php

use Illuminate\Database\Seeder;

class LanguageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = config('languages.languages');
        foreach ($languages as $language) {
            if (\App\Language::where('slug', str_slug($language))->first()) {
            } else {
                $ln = new \App\Language;
                $ln->name = $language;
                $ln->slug = str_slug($language);
                $ln->save();
            }
        }
    }
}

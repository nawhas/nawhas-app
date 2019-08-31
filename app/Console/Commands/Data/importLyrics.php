<?php

namespace App\Console\Commands\Data;

use App\Lyric;
use App\Reciter;
use File;
use Illuminate\Console\Command;
use Storage;

class importLyrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:importLyrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->info("This script will upload all lyrics attached to a track");

        $reciter = null;
        $album = null;

        // Go through each folder and get the reciter and album details
        $lyricsFolder = Storage::disk('public')->directories('lyrics');

        // Loop through lyrics folder and get each reciters name
        foreach ($lyricsFolder as $lyricFolder) {
            // Set the reciters name
            $reciter = substr($lyricFolder, strrpos($lyricFolder, '/') + 1);
            $this->info("Reciter Folder Name: $reciter");
            $reciter = Reciter::where('name', $reciter)->first();
            // Loop through reciters folder to get album details
            $albumsFolder = Storage::disk('public')->directories($lyricFolder);
            foreach ($albumsFolder as $albumFolder) {
                // Set the Album details
                $album = substr($albumFolder, strrpos($albumFolder, '/') + 1);
                $this->info("Reciter Name: $reciter->name Album Folder: $album");
                $album = $reciter->albums()->where('year', $album)->first();
                foreach ($album->tracks as $track) {
                    if (Storage::exists("$albumFolder/$track->number.txt")) {
                        // Read the file and store the lyric into database
                        $textFileContent = Storage::disk('public')->get("$albumFolder/$track->number.txt");
                        $textFileContent = str_replace("’", "'", $textFileContent);
                        $textFileContent = mb_convert_encoding($textFileContent, 'UTF-8', 'Windows-1252');

                        $lyric = new Lyric();
                        $lyric->track_id = $track->id;
                        $lyric->text = $textFileContent;
                        $lyric->native_language = true;
                        $lyric->created_by = 1;
                        $lyric->save();
                    }
                }
            }
        }
    }
}

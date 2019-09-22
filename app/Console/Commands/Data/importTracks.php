<?php

namespace App\Console\Commands\Data;

use App\Album;
use App\Reciter;
use App\Track;
use Illuminate\Console\Command;
use Storage;

class importTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:importTracks';

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
     */
    public function handle()
    {
        $this->info("This script will import all tracks from a CSV sheet");

        $csvData = $this->readCSV(Storage::disk('public')->path('tracks.csv'));

        $reciter = null;
        $album = null;

        $trackNumber = null;

        foreach ($csvData as $track)
        {
            $reciterName = $track['Reciter Name'];
            $albumYear = $track['Album Year'];
            $trackName = $track['Track Name'];

            if ($reciterName) {
                $reciter = Reciter::where('name', $reciterName)->first();
            }

            if ($albumYear) {
                $album = Album::where('reciter_id', $reciter->id)->where('year', $albumYear)->first();
                $trackNumber = 1;
            }

            $this->info("Importing $reciter->name Album $album->year Track Number $trackNumber Track Name $trackName");

            // storing data into database
            $track = new Track();
            $track->name = $trackName;
            $track->slug = str_slug($trackName);
            $track->reciter_id = $reciter->id;
            $track->album_id = $album->id;
            $track->audio = null;
            $track->video = null;
            $track->number = $trackNumber;
            $track->created_by = 1;
            $track->save();

            $trackNumber++;
        }
    }

    public function readCSV($file) {
        $header = null;
        $data = array();
        if (($handle = fopen($file, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, ',')) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);

            return $data;
        }
    }
}

<?php

namespace App\Console\Commands\Data;

use App\Album;
use App\Reciter;
use Illuminate\Console\Command;
use Storage;

class importAlbums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:importAlbums';

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
        $this->info("This script will import all albums from a CSV sheet");

        // Read CSV File

        $csvData = $this->readCSV(Storage::disk('public')->path('albums.csv'));

        $reciter = null;

        foreach ($csvData as $album)
        {
            $reciterName = $album['Reciter Name'];
            if ($reciterName) {
                $reciter = Reciter::where('name', $reciterName)->first();
            }

            $albumName = $album['Album Name'];
            $albumYear = $album['Album Year'];

            $this->info("Importing $reciter->name Album $albumName Year $albumYear");

            $album = new Album();
            $album->name = $albumName;
            $album->reciter_id = $reciter->id;
            $album->year = $albumYear;
            $album->artwork = null;
            $album->created_by = 1;
            $album->save();
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

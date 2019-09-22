<?php

namespace App\Console\Commands\Data;

use App\Reciter;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Storage;

class importReciters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:importReciters';

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
        $this->info("This script will import all reciters from a CSV sheet");

        // Read CSV File

        $csvData = $this->readCSV(Storage::disk('public')->path('reciters.csv'));

        // Go through each reciter and import into database
        for ($i = 0; $i < count($csvData); $i ++)
        {
            $reciterName = $csvData[$i]['Reciter Name'];

            $reciter = new Reciter();
            $reciter->name = $reciterName;
            $reciter->slug = str_slug($reciterName);
            $reciter->description = null;
            $reciter->avatar = null;
            $reciter->created_by = 1;
            $reciter->save();
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

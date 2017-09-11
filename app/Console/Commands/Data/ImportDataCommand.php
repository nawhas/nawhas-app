<?php

namespace App\Console\Commands\Data;

use File;
use App\Reciter;
use App\Album;
use App\Track;
use Illuminate\Console\Command;

class ImportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to import data from a folder structure';

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
        /*
         * /reciters
       -> /Nadeem Sarwar
            -> avatar.jpg
            -> bio.txt
            -> /2013 - Muharram 1436
                  -> artwork.jpg
                  -> /01 - Allah Allah Min Raasil Ya Hussain
                          -> lyrics.txt
                          -> audio.mp3
        */
        $this->comment('This command will help you import data for nawhas.com');

        $this->comment('Verifying installation prerequisites...');
        $dir = 'public/uploads/reciters';
        if(!File::exists($dir)) {
            $this->error('Please create reciters folder');
            return;
        } else {
            $this->comment('The reciters folder exists');
        }

        $this->comment('Scanning the directory for reciters');
        $reciterContent = scandir($dir);
        unset($reciterContent[0]);
        unset($reciterContent[1]);
        $reciterContent = array_values($reciterContent);
        if(!count($reciterContent) > 0) {
            $this->error("There are no reciters");
            return;
        } else {
            $this->comment('reciters were found');
        }
        foreach ($reciterContent as $d) {
            $reciterBio = $dir . '/' . $d . '/bio.txt';
            if(!file_exists($reciterBio)) {
                $this->error('bio.txt does not exist for ' . $d);
                return;
            } else {
                $this->comment('successfully found bio.txt');
            }
            if(!$reciterBio = file_get_contents($reciterBio, true)) {
                $this->error('An error occurred when trying to read bio.txt for ' . $d);
                return;
            } else {
                $this->comment('Successfully imported bio from txt');
            }

            $reciterAvatarFile = '';
            $reciterAvaterPNG = $dir . '/' . $d . '/avatar.png';
            $reciterAvaterJPEG = $dir . '/' . $d . '/avatar.jpg';

            if(file_exists($reciterAvaterJPEG)) {
                $reciterAvatarFile = 'avatar.jpg';
            } else if(file_exists($reciterAvaterPNG)) {
                $reciterAvatarFile = 'avatar.png';
            }
            if(!$reciterAvatarFile) {
                $this->error($d . ' does not have an avatar.png or avatar.jpg file');
                return;
            } else {
                $this->comment('Avatar found for ' . $d);
            }

            $reciter = new Reciter;
            $reciter->name = $d;
            $reciter->slug = str_slug($d);
            $reciter->description = $reciterBio;
            $reciter->image_path = $reciterAvatarFile;
            $reciter->created_by = 1;
            if(!$reciter->save()) {
                $this->error('Reciter did not save');
                return;
            } else {
                $this->comment('Reciter ' . $d . ' has been created');
            }
        }

        $this->info('Data imported successfully.');
    }
}

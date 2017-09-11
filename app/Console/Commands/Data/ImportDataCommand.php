<?php

namespace App\Console\Commands\Data;

use App\Lyric;
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
        foreach ($reciterContent as $reciterName) {
            // set variables
            $reciterSlug = str_slug($reciterName);
            $reciterDir = $dir . '/' . $reciterName;
            $reciterBio = $reciterDir . '/bio.txt';
            $reciterAvatarFile = '';
            $reciterAvaterPNG = $reciterDir . '/avatar.png';
            $reciterAvaterJPEG = $reciterDir . '/avatar.jpg';

            // check if the reciter does not exist in db
            if(!$reciter = Reciter::where('slug', $reciterSlug)->first()) {
                // check if bio file exists
                if(!file_exists($reciterBio)) {
                    $this->error('bio.txt does not exist for ' . $reciterName);
                    return;
                } else {
                    $this->comment('successfully found bio.txt');
                }
                if(!$reciterBio = file_get_contents($reciterBio, true)) {
                    $this->error('An error occurred when trying to read bio.txt for ' . $reciterName);
                    return;
                } else {
                    $this->comment('Successfully imported bio from txt');
                }

                // check if avatar exists
                if(file_exists($reciterAvaterJPEG)) {
                    $reciterAvatarFile = 'avatar.jpg';
                } else if(file_exists($reciterAvaterPNG)) {
                    $reciterAvatarFile = 'avatar.png';
                }
                if(!$reciterAvatarFile) {
                    $this->error($reciterName . ' does not have an avatar.png or avatar.jpg file');
                    return;
                } else {
                    $this->comment('Avatar found for ' . $reciterName);
                }

                // create reciter
                $reciter = new Reciter;
                $reciter->name = $reciterName;
                $reciter->slug = $reciterSlug;
                $reciter->description = $reciterBio;
                $reciter->image_path = $reciterAvatarFile;
                $reciter->created_by = 1;
                if(!$reciter->save()) {
                    $this->error('Reciter did not save');
                    return;
                } else {
                    $this->comment('Reciter ' . $reciterName . ' has been created');
                }
            } else {
                $this->comment($reciterName . ' already exists');
            }

            //albums section
            $this->comment('checking for prerequisites for albums');
            $this->comment('Scanning in ' . $reciter->name . '(s) directory for albums');
            $albumsDir = $reciterDir . '/albums';
            $albumsContent = scandir($albumsDir);
            unset($albumsContent[0]);
            unset($albumsContent[1]);
            $albumsContent = array_values($albumsContent);
            if(!count($albumsContent) > 0) {
                $this->error("There are no albums for " . $reciterName);
            } else {
                $this->comment('albums were found');
            }

            // loop through albums
            foreach ($albumsContent as $albumContent) {
                list($albumYear, $albumHijri, $albumName) = explode(' - ', $albumContent);
                list($albumHijriMonth, $albumHijriYear) = explode(' ', $albumHijri);

                //check if album exists
                $albumDir = $albumsDir . '/' . $albumContent;
                if(!$album = $reciter->albums->where('year', $albumYear)->first()) {
                    $albumArtworkFile = '';
                    $albumArtworkPNG = $albumDir . '/artwork.png';
                    $albumArtworkJPEG = $albumDir . '/artwork.jpg';
                    //check if artwork exists
                    if(file_exists($albumArtworkPNG)) {
                        $albumArtworkFile = 'artwork.jpg';
                    } else if(file_exists($albumArtworkJPEG)) {
                        $albumArtworkFile = 'artwork.png';
                    }
                    if(!$albumArtworkFile) {
                        $this->error($reciterName . ' does not have an artowrk.png or artwork.jpg for year' . $albumYear);
                        return;
                    } else {
                        $this->comment('Avatar found for ' . $reciterName . ' Album '. $albumYear);
                    }
                    // create Album
                    $album = new Album;
                    $album->reciter_id = $reciter->id;
                    $album->name = $albumName;
                    $album->year = $albumYear;
                    $album->image_path = $albumArtworkFile;
                    $album->created_by = 1;
                    $album->save();
                } else {
                    $this->comment($albumYear .' Album Found');
                }

                // tracks section
                $this->comment('checking for prerequisites for tracks');
                $this->comment('Scanning in ' . $reciter->name . '(s) directory for tracks in album ' . $albumYear);
                $tracksDir = $albumDir . '/tracks';
                $tracksContent = scandir($tracksDir);
                unset($tracksContent[0]);
                unset($tracksContent[1]);
                $tracksContent = array_values($tracksContent);
                if(!count($tracksContent) > 0) {
                    $this->error("There are no tracks for album " . $albumYear . ' for reciter ' . $reciterName);
                } else {
                    $this->comment('tracks were found');
                }
                foreach ($tracksContent as $trackContent) {
                    list($trackNumber, $trackName) = explode(' - ', $trackContent);
                    $trackDir = $tracksDir . '/' . $trackContent;
                    $trackSlug = str_slug($trackName);
                    if(!$track = Track::where('slug', $trackSlug)->first()){
                        if(!file_exists($trackDir . '/audio.mp3')) {
                            $this->error('no audio file');
                            return;
                        }
                        $track = new Track();
                        $track->name = $trackName;
                        $track->slug = str_slug($trackName);
                        $track->album_id = $album->id;
                        $track->audio = 'audio.mp3';
                        $track->track_number = $trackNumber;
                        $track->language = 'en';
                        $track->created_by = 1;
                        $track->save();
                        $this->comment('Track created successfully');
                    } else {
                        $this->comment('Track already exists');
                    }

                    // lyrics
                    $this->comment('checking for prerequisites for lyrics');
                    if(!$lyric = $track->lyrics) {
                        if(!file_exists($trackDir . '/lyrics.txt')) {
                            $this->error('Lyric does not exist for reciter ' . $reciterName . ' Album ' . $albumYear . ' Track ' . $trackName);
                        } else {
                            $lyricFile = $trackDir . '/lyrics.txt';
                            if(!$lyricFile = file_get_contents($lyricFile, true)) {
                                $this->error('An error occurred when trying to read lyrics.txt for');
                                return;
                            } else {
                                $this->comment('Successfully imported bio from txt');
                            }
                            $lyric = new Lyric();
                            $lyric->track_id = $track->id;
                            $lyric->text = $lyricFile;
                            $lyric->language = 'en';
                            $lyric->created_by = 1;
                            $lyric->save();
                            $this->comment('Successfully created lyric');
                        }
                    }else {
                        $this->comment('Lyric already exists');
                    }
                }
            }
        }
    }
}

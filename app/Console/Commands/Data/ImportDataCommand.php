<?php

namespace App\Console\Commands\Data;

use App\Lyric;
use App\Reciter;
use App\Album;
use App\Support\File\ExplicitExtensionFile;
use App\Track;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ImportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import reciters, albums, and nawhas from a folder.';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directory = $this->argument('path');

        if (!$this->filesystem->exists($directory)) {
            $this->error("The directory you specified does not exist. [{$directory}]");

            return;
        }

        $this->comment('Importing data from ' . $directory . '');

        $this->importReciters($directory);
    }

    private function importReciters(string $baseDirectory)
    {
        $directories = $this->filesystem->directories($baseDirectory);

        if (!count($directories) > 0) {
            $this->error('There are no reciters');

            return;
        }

        $this->info('Found ' . count($directories) . ' reciters!');

        foreach ($directories as $directory) {
            $name = basename($directory);

            $this->comment('>> Importing "' . $name . '"');

            // Check to see if a reciter with this name already exists.
            $reciter = Reciter::where('name', $name)->first();

            // If it doesn't exist already, create a new one.
            if ($reciter === null) {
                $reciter = new Reciter(['name' => $name]);
            }

            // Set the slug.
            $reciter->slug = str_slug($reciter->name);

            // Set the bio for the reciter if bio.txt exists.
            $bioFile = $directory . '/bio.txt';
            if ($this->filesystem->exists($bioFile)) {
                $reciter->description = trim($this->filesystem->get($bioFile));
            }

            $avatar = $this->filesystem->glob($directory . '/avatar.*');

            if (count($avatar) > 0) {
                $avatarFilePath = array_first($avatar);
                $reciter->avatar = $this->uploadFile($avatarFilePath, 'reciters');
            }

            $reciter->save();

            $this->importAlbums($reciter, $directory);
        }

        $this->info('All done!');
    }

    private function importAlbums(Reciter $reciter, string $directory)
    {
        $directories = $this->filesystem->directories($directory);

        $this->comment("\tFound " . count($directories) . ' albums...');

        foreach ($directories as $directory) {
            $base = $this->filesystem->basename($directory);

            $this->comment("\t>> Importing \"{$base}\"");

            list($year, $name) = explode(' - ', $base);

            /** @var Album|null $album */
            $album = $reciter->albums()
                ->where('year', $year)
                ->where('name', $name)
                ->first();

            if ($album === null) {
                $album = new Album([
                    'year' => $year,
                    'name' => $name,
                ]);
            }

            $artwork = $this->filesystem->glob($directory . '/artwork.*');

            if (count($artwork) > 0) {
                $artworkFilePath = array_first($artwork);
                $album->artwork = $this->uploadFile($artworkFilePath, 'albums');
            }

            $reciter->albums()->save($album);

            $this->importTracks($reciter, $album, $directory);
        }
    }

    private function importTracks(Reciter $reciter, Album $album, string $directory)
    {
        $directories = $this->filesystem->directories($directory);

        $this->comment("\t\tFound " . count($directories) . ' tracks...');

        foreach ($directories as $directory) {
            $base = $this->filesystem->basename($directory);

            $this->comment("\t\t>> Importing \"{$base}\"");

            list($number, $name) = explode(' - ', $base);

            /** @var Track|null $album */
            $track = $album->tracks()
                ->where('name', $name)
                ->first();

            if ($track === null) {
                $track = new Track([
                    'name' => $name,
                ]);
            }

            $track->reciter_id = $album->reciter_id;
            $track->number = $number;
            $track->slug = str_slug($name);

            // Get Audio Path
            $audio = $this->filesystem->glob($directory . '/audio.*');
            if (count($audio) > 0) {
                $audioFilePath = array_first($audio);
                $track->audio = $this->uploadFile($audioFilePath, 'tracks');
            }

            $album->tracks()->save($track);

            // Lyrics
            if ($this->filesystem->exists($directory . '/lyrics.txt')) {
                $lyrics = $track->lyrics;

                if (!$lyrics) {
                    $lyrics = new Lyric();
                }

                $text = $this->filesystem->get($directory . '/lyrics.txt');
                $lyrics->text = $text;
                $track->lyrics()->save($lyrics);
            }
        }
    }

    protected function uploadFile(string $file, string $directory) : string
    {
        $extension = $this->filesystem->extension($file);
        $md5 = $this->filesystem->hash($file);
        $filename = $md5 . '.' . $extension;
        $path = $directory . '/' . $filename;
        if (Storage::exists($path)) {
            return Storage::url($path);
        }
        $uploadedFilePath = Storage::putFileAs($directory, new ExplicitExtensionFile($file), $filename, 'public');
        return Storage::url($uploadedFilePath);
    }
}

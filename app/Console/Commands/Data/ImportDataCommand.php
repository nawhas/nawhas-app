<?php

namespace App\Console\Commands\Data;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;

class ImportDataCommand extends Command
{
    private const IGNORED_LINKS = [
        'Others',
        'Duas and Ziyaraat',
        'ABOUT US',
        'SUPPORT US',
        'LINKS',
        'DESIGN BY KASH',
    ];

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
    protected $description = 'Import Nawhas.com Data';
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Guzzle $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reciters = $this->getReciters();

        $this->table(['name', 'link'], $reciters);
    }

    /**
     * @return array
     */
    private function getReciters()
    {
        $response = $this->client->get('http://www.nawhas.com/index2.html');

        $dom = new Dom();
        $dom->load($response->getBody()->getContents());

        /** @var \PHPHtmlParser\Dom\AbstractNode $table */
        $table = $dom->find('form table');
        $links = $table->find('a');

        $reciters = [];

        foreach ($links as $link) {
            /** @var Dom\AbstractNode $link */
            if (count($link->find('img')) > 0) {
                continue;
            }

            $name = trim(strip_tags($link->innerHtml()));

            if (!$name) {
                continue;
            }

            if (in_array($name, self::IGNORED_LINKS, true)) {
                continue;
            }
            $url = $link->getAttribute('href');

            $reciters[] = [
                'name' => $name,
                'link' => $url,
                'albums' => $this->getAlbums($name, $url),
            ];
        }

        return $reciters;
    }

    private function getAlbums($reciter, $url)
    {
        $dom = new Dom();
        $dom->loadFromUrl('http://nawhas.com/' . $url);

        
    }
}

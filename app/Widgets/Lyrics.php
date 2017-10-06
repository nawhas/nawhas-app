<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;

class Lyrics extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = \App\Lyric::count();
        $string = 'Lyrics';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-news',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager.dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Lyrics'),
                'link' => route('voyager.lyrics.index'),
            ],
            'image' => 'https://images.unsplash.com/photo-1457637809455-3a18d58f16c3?dpr=1&auto=compress,format&fit=crop&w=1789&h=&q=80&cs=tinysrgb&crop=',
        ]));
    }
}

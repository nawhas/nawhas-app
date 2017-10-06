<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;

class Reciters extends AbstractWidget
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
        $count = \App\Reciter::count();
        $string = 'Reciters';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-news',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager.dimmer.post_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('Reciters  '),
                'link' => route('voyager.reciters.index'),
            ],
            'image' => 'https://images.unsplash.com/photo-1461353789837-8eb180f968d2?dpr=1&auto=compress,format&fit=crop&w=1951&h=&q=80&cs=tinysrgb&crop=',
        ]));
    }
}

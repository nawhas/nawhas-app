<?php

namespace App\Support\File;

use Illuminate\Http\File;

class ExplicitExtensionFile extends File
{
    /** @var string */
    protected $extension;

    public function __construct($path, $extension = null, $checkPath = true)
    {
        parent::__construct($path, $checkPath);
        $this->extension = $extension ?: \File::extension($path);
    }

    public function guessExtension()
    {
        return $this->extension;
    }
}

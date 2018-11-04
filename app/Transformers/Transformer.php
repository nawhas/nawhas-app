<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{
    /**
     * Create a transformer that excludes default includes.
     *
     * @param string[] $excludes
     *
     * @return static
     */
    public static function excluding(string ...$excludes)
    {
        $transformer = new static();
        $transformer->setDefaultIncludes(
            array_diff($transformer->getDefaultIncludes(), $excludes)
        );

        return $transformer;
    }
}

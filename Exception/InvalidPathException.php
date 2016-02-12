<?php

namespace Ju\SimpleSearchBundle\Exception;

class InvalidPathException extends \InvalidArgumentException
{
    /**
     * @inheritdoc
     */
    public function __construct($path)
    {
        parent::__construct(sprintf('Only file must be an argument. Invalid path $s', $path));
    }

}
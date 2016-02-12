<?php

namespace Ju\SimpleSearchBundle\Engine\Iterators;

class PregMatchIterator extends \FilterIterator
{

    private $pattern;

    /**
     * @inheritdoc
     */
    public function __construct($iterator, $pattern)
    {
        $this->pattern = $pattern;
        parent::__construct($iterator);
    }

    /**
     * @inheritdoc
     */
    public function accept()
    {
        $r = $this->current()->getFileName();
        return preg_match('~' . $this->pattern . '~', $this->current()->getFileName());
    }
}
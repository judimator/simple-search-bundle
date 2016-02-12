<?php

namespace Ju\SimpleSearchBundle\Engine\Iterators;

class FileContentIterator extends \FilterIterator
{

    const BUFFER = 4096;

    private $needle;
    private $func;

    /**
     * @inheritdoc
     */
    public function __construct($iterator, $needle, $case)
    {
        $this->needle = $needle;
        $this->func = $case ? 'mb_strpos' : 'mb_stripos';
        parent::__construct($iterator);
    }

    /**
     * @inheritdoc
     */
    public function accept()
    {
        $current = $this->current();
        $fileObj = $current->openFile('r');
        $prevStack = '';
        while (!$fileObj->eof()) {
            $stack = $fileObj->fread(self::BUFFER);
            if (false === $this->{$this->func}($prevStack . $stack, $this->needle)) {
                $prevStack = $stack;
            } else {
                return true;
            }
        }
    }

    public function mb_strpos($haystack, $needle, $offset = 0)
    {
        return mb_strpos($haystack, $needle, $offset);
    }

    public function mb_stripos($haystack, $needle, $offset = 0)
    {
        return mb_stripos($haystack, $needle, $offset);
    }

}
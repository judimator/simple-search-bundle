<?php

namespace Ju\SimpleSearchBundle\Engine\Iterators;

class FileIterator extends \FilterIterator
{

    private static $fInstance;

    /**
     * @inheritdoc
     */
    public function accept()
    {
        $current = $this->current();

        return $current->isFile() && $current->isReadable() && $this->isBinary() ? true : false;
    }

    /**
     * @return bool
     */
    public function isBinary()
    {
        $fInstance = static::fInstance();
        
        return substr(finfo_file($fInstance, $this->current()->getPathName()), 0, 4) == 'text';
    }

    /**
     * @return resource
     */
    public static function fInstance()
    {
        if (null === self::$fInstance) {
            return finfo_open(FILEINFO_MIME);
        }

        return  self::$fInstance;
    }

}
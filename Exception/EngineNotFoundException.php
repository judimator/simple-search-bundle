<?php

namespace Ju\SimpleSearchBundle\Exception;

class EngineNotFoundException extends \InvalidArgumentException
{

    /**
     * @inheritdoc
     */
    public function __construct($type)
    {
        parent::__construct(sprintf('Engine %s with same type no found.', $type));
    }

}
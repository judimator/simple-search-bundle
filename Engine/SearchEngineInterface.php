<?php

namespace Ju\SimpleSearchBundle\Engine;

interface SearchEngineInterface
{

    /**
     * @param $needle
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function find($needle);

}
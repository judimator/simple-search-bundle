<?php

namespace Ju\SimpleSearchBundle\Engine;

use Ju\SimpleSearchBundle\Engine\SearchEngineInterface;
use Ju\SimpleSearchBundle\Exception\EngineNotFoundException;

class EngineCollection
{

    public $defaultEngine;
    public $engines = array();

    /**
     * Return an engine
     *
     * @param null $type
     * @return mixed
     */
    public function get($type = null)
    {
        $type = $type ?: $this->defaultEngine;

        if (!$type || !array_key_exists($type, $this->engines)) {
            throw new EngineNotFoundException($type);
        }

        return $this->engines[$type];
    }

    /**
     * Add an engine to collection
     *
     * @param $type
     * @param \Ju\SimpleSearchBundle\Engine\SearchEngineInterface $engine
     */
    public function add($type, SearchEngineInterface $engine)
    {
        $this->engines[$type] = $engine;
    }

    /**
     * @param $engine
     */
    public function setDefault($engine)
    {
        $this->defaultEngine = $engine;
    }

}
<?php

namespace Ju\SimpleSearchBundle\Engine;

use Ju\SimpleSearchBundle\Engine\SearchEngineInterface;
use Ju\SimpleSearchBundle\Engine\Iterators\FileIterator;
use Ju\SimpleSearchBundle\Engine\Iterators\PregMatchIterator;
use Ju\SimpleSearchBundle\Engine\Iterators\FileContentIterator;

class JuFinderEngine implements SearchEngineInterface, \IteratorAggregate, \Countable
{

    public $dirs;
    public $pattern;
    public $needle;
    public $case;

    /**
     * {@inheritDoc}
     */
    public function find($needle)
    {
        $this->needle = $needle;

        $response = array();
        $iterator = $this->getIterator();
        iterator_to_array($iterator);
        foreach ($iterator as $file) {
            $response[] = $file->getPathname();
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        if (1 === count($this->dirs)) {
            return $this->searchInDir($this->dirs[0]);
        }

        $iterator = new \AppendIterator();
        foreach ($this->dirs as $dir) {
            $iterator->append($this->searchInDir($dir));
        }

        return $iterator;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return iterator_count($this->getIterator());
    }

    /**
     * Set an iterator by option
     *
     * @param $dir
     * @return \Iterator
     */
    public function searchInDir($dir)
    {
        $iterator = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new FileIterator($iterator);

        if ($this->pattern) {
            $iterator = new PregMatchIterator($iterator, $this->pattern);
        }

        $iterator = new FileContentIterator($iterator, $this->needle, $this->case);


        return $iterator;
    }

    /**
     * Searches files and directories which match defined rules.
     *
     * @param string|array $dirs A directory path or an array of directories
     *
     * @return $this
     */
    public function in($dirs)
    {
        $resolvedDirs = array();
        foreach ((array) $dirs as $dir) {
            if (is_dir($dir)) {
                $resolvedDirs[] = $dir;
            } else {
                throw new \InvalidArgumentException(sprintf('The "%s" directory does not exist.', $dir));
            }
        }
        $this->dirs = $resolvedDirs;
        return $this;
    }

    /**
     * Set patter fo searching
     *
     * @param $pattern
     * @return $this
     */
    public function filter($pattern)
    {
        if (!is_string($pattern) && null !== $pattern) {
            throw new \InvalidArgumentException(sprintf('The pattern "%s" does not valid.', $pattern));
        }
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @param $case
     * @return $this
     */
    public function caseSensitive($case)
    {
        $this->case = (bool)$case;

        return $this;
    }
}



<?php

namespace Ju\SimpleSearchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ju\SimpleSearchBundle\Engine\SearchEngineInterface;

class FindFileCommand extends ContainerAwareCommand
{

    /**
     * @var SearchEngineInterface
     */
    public $engine;

    /**
     * @var null|string
     */
    public $defaultEngine;

    /**
     * @var string|array
     */
    public $engines;

    /**
     * @param null|string $defaultEngine
     * @param array $engines
     */
    public function __construct($defaultEngine, $engines = array())
    {
        $this->engines = $engines;
        $this->defaultEngine = $defaultEngine;

        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('find')
            ->setDescription('Find file in directory')
            ->addArgument('string', InputArgument::REQUIRED, 'Searched content')
            ->addArgument(
                'dirs',
                InputArgument::IS_ARRAY,
                'Dirs for searching.'
            )

            ->addOption(
                'engine',
                null,
                InputOption::VALUE_REQUIRED,
                sprintf('Engine for searching. Allowed - %s', implode(', ', array_keys($this->engines))),
                $this->defaultEngine
            )
            ->addOption(
                'pattern',
                null,
                InputOption::VALUE_OPTIONAL,
                'File patten for searching.'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->engine = $this->getContainer()->get('ju.search.factory')->get($input->getOption('engine'));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $needle = $input->getArgument('string');
        $dirs = $input->getArgument('dirs');
        $pattern = $input->getOption('pattern');
        $result = $this->engine->in($dirs)->filter($pattern)->caseSensitive(false)->find($needle);
        $output->writeln(implode(', ', $result));
    }
}

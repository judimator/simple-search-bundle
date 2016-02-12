<?php

namespace Ju\SimpleSearchBundle\Tests\Unit\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ju\SimpleSearchBundle\DependencyInjection\JuSimpleSearchExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SimpleSearchExtensionTest extends WebTestCase
{
    public function testDefinition()
    {
        $container = $this->getContainer('have_engine.yml');

        $this->assertEquals('ju_engine_two', $container->getParameter('ju.search.default_engine'));
    }

    public function testDefaultDefinition()
    {
        $container = $this->getContainer('no_have_engine.yml');

        $this->assertEquals('ju_engine', $container->getParameter('ju.search.default_engine'));
    }

    private function getContainer($file)
    {
        $container = new ContainerBuilder();

        $container->registerExtension(new JuSimpleSearchExtension());

        $fileLocator = new FileLocator(__DIR__ . '/Fixtures');
        $loader = new YamlFileLoader($container, $fileLocator);

        $loader->load($file);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}

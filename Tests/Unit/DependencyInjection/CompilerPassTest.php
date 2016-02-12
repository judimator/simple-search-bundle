<?php

namespace Ju\SimpleSearchBundle\Tests\Unit\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Ju\SimpleSearchBundle\DependencyInjection\Compiler\CompilerPass;
use Ju\SimpleSearchBundle\DependencyInjection\JuSimpleSearchExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class CompilerPassTest extends \PHPUnit_Framework_TestCase
{

    public function testProcess()
    {
        $compiler = new CompilerPass();

        $container = $this->getContainer('no_have_engine.yml');

        $definition = new Definition('Ju\SimpleSearchBundle\Engine\JuFinderEngine');

        $definition->addTag('ju.search.engine', array('type' => 'ju_engine2'));
        $container->setDefinition('ju.search.engine.finder2', $definition);
        $container->addCompilerPass($compiler);
        $container->compile();

        $callMethods = $container->getDefinition('ju.search.factory')->getMethodCalls();
        $this->assertEquals('ju_engine', $callMethods[2][1][0]);

        $engines = $container->getParameter('ju.search.engines');
        $this->assertCount(2, $engines);
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

        return $container;
    }
}

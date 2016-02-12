<?php

namespace Ju\SimpleSearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $engines = array();
        $factory = $container->getDefinition('ju.search.factory');
        $defaultEngine = $container->getParameter('ju.search.default_engine');
        $factory->addMethodCall('setDefault', array($defaultEngine));
        foreach ($container->findTaggedServiceIds('ju.search.engine') as $id => $attr) {
            $attr = $attr[0];
            if (!array_key_exists('type', $attr)) {
                throw new \InvalidArgumentException('Search engine tag must have "type" attribute');
            }

            $engines[$attr['type']] = $id;
            $factory->addMethodCall('add', array($attr['type'], new Reference($id)));
        }

        $container->setParameter('ju.search.engines', $engines);
    }

}

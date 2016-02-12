<?php

namespace Ju\SimpleSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ju_simple_search');

        $rootNode
            ->children()
                ->scalarNode('engine')
                    ->defaultValue('ju_engine')
                ->end()
            ->end();

        return $treeBuilder;
    }

}

<?php

namespace Rocketage\Sculpin\Bundle\MultilingualBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('sculpin_multilingual');
        $rootNode
            ->children()
                ->scalarNode('shared_directory')
                    ->defaultValue('shared')
                ->end()
                ->arrayNode('target_directories')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

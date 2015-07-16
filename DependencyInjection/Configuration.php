<?php

namespace Brother\MapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('brother_map');

        $rootNode
            ->children()
                ->floatNode('latitude')->cannotBeEmpty()->end()
                ->floatNode('longitude')->cannotBeEmpty()->end()
                ->arrayNode('yandex')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('html_id')->defaultValue('ymap')->end()
                        ->integerNode('zoom')->min(1)->defaultValue(12)->end()
                        ->scalarNode('type')->defaultValue('yandex#hybrid')->end()
                        ->arrayNode('controls')->end()
                        ->arrayNode('objects')->end()
                    ->end()
                ->end()
                ->arrayNode('google')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('html_id')->defaultValue('ymap')->end()
                        ->integerNode('zoom')->min(1)->defaultValue(12)->end()
                        ->scalarNode('type')->defaultValue('yandex#hybrid')->end()
                        ->arrayNode('controls')->end()
                        ->arrayNode('objects')->end()
                    ->end()
                ->end()
            ->end()
        ->end();
        return $treeBuilder;
    }
}

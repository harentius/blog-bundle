<?php

namespace Harentius\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('harentius_blog');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('title')
                    ->defaultValue('')
                ->end()
                ->arrayNode('sidebar')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('tags_limit')
                            ->defaultValue(10)
                        ->end()
                        ->arrayNode('tag_sizes')
                            ->prototype('integer')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('homepage')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('page_slug')
                        ->defaultValue(null)
                    ->end()
                    ->arrayNode('feed')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('category')
                                ->defaultValue(null)
                            ->end()
                            ->scalarNode('number')
                                ->defaultValue(10)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('list')
                ->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('posts_per_page')
                        ->defaultValue(10)
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

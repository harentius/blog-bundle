<?php

namespace Harentius\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('harentius_blog');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->arrayNode('locales')
                ->prototype('scalar')->end()
            ->end()
            ->scalarNode('primary_locale')->isRequired()->end()
            ->arrayNode('sidebar')
                ->children()
                    ->scalarNode('cache_lifetime')->defaultValue(0)->end()
                    ->integerNode('tags_limit')->defaultValue(10)->end()
                    ->arrayNode('tag_sizes')
                        ->prototype('integer')->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('homepage')
                ->children()
                    ->scalarNode('page_slug')->defaultValue(null)->end()
                ->end()
                ->children()
                    ->arrayNode('feed')
                        ->children()
                            ->scalarNode('category')->defaultValue(null)->end()
                            ->scalarNode('number')->defaultValue(null)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('list')
                ->children()
                    ->integerNode('posts_per_page')->defaultValue(10)->end()
                ->end()
            ->end()
            ->arrayNode('cache')
                ->children()
                    ->scalarNode('apc_global_prefix')->defaultValue('harentius_blog')->end()
                ->end()
            ->end()
            ->arrayNode('articles')
                ->children()
                    ->scalarNode('image_previews_base_uri')->defaultValue('/assets/images/preview/')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

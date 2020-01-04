<?php

namespace Harentius\BlogBundle\DependencyInjection;

use Harentius\BlogBundle\Twig\BlogExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HarentiusBlogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services/services.yml');
        $loader->load('services-repositories.yml');
        $loader->load('services-cache.yml');

        $twigExtensionDefinition = $container->getDefinition(BlogExtension::class);
        $cacheService = ($config['sidebar']['cache_lifetime'] === null)
            ? 'harentius_blog.array_cache'
            : 'harentius_blog.sidebar.cache'
        ;
        $cacheServiceDefinition = $container->getDefinition($cacheService);

        $twigExtensionDefinition->replaceArgument(1, $cacheServiceDefinition);
        $articleAdminDefinition = $container->getDefinition('harentius_blog.admin.article');
        $articleAdminDefinition->addMethodCall('setControllerCache', [$cacheServiceDefinition]);

        $container->setParameter('harentius_blog.sidebar.tags_limit', $config['sidebar']['tags_limit']);
        $container->setParameter('harentius_blog.sidebar.tag_sizes', $config['sidebar']['tag_sizes']);
        $container->setParameter('harentius_blog.homepage.page_slug', $config['homepage']['page_slug']);
        $container->setParameter('harentius_blog.homepage.feed.category', $config['homepage']['feed']['category']);
        $container->setParameter('harentius_blog.homepage.feed.number', $config['homepage']['feed']['number']);
        $container->setParameter('harentius_blog.list.posts_per_page', $config['list']['posts_per_page']);
        $container->setParameter('harentius_blog.cache.apc_global_prefix', $config['cache']['apc_global_prefix']);
        $container->setParameter('harentius_blog.cache.statistics_cache_lifetime', $config['cache']['statistics_cache_lifetime']);
        $container->setParameter('harentius_blog.sidebar.cache_lifetime', $config['sidebar']['cache_lifetime']);
        $container->setParameter('harentius_blog.homepage.page_slug', $config['homepage']['page_slug']);
        $container->setParameter('harentius_blog.articles.image_previews_base_uri', $config['articles']['image_previews_base_uri']);
        $container->setParameter('harentius_blog.locales', $config['locales']);
        $container->setParameter('harentius_blog.primary_locale', $config['primary_locale']);
        $container->setParameter('harentius_blog.articles.sharethis.property', $config['articles']['sharethis']['property']);
        $container->setParameter('harentius_blog.articles.sharethis.product', $config['articles']['sharethis']['product']);
    }
}

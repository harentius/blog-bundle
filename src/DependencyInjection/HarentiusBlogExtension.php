<?php

namespace Harentius\BlogBundle\DependencyInjection;

use Harentius\BlogBundle\Twig\GlobalsExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HarentiusBlogExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $globalsExtension = $container->getDefinition(GlobalsExtension::class);
        $globalsExtension->addMethodCall('addGlobal', ['harentius_blog_title', $config['title']]);
        $globalsExtension->addMethodCall('addGlobal', ['harentius_blog_theme', $config['theme']]);
        $globalsExtension->addMethodCall('addGlobal', ['harentius_blog_highlight_code', $config['highlight_code']]);

        $container->setParameter('harentius_blog.sidebar.tags_limit', $config['sidebar']['tags_limit']);
        $container->setParameter('harentius_blog.sidebar.tag_sizes', $config['sidebar']['tag_sizes']);
        $container->setParameter('harentius_blog.homepage.page_slug', $config['homepage']['page_slug']);
        $container->setParameter('harentius_blog.homepage.feed.category', $config['homepage']['feed']['category']);
        $container->setParameter('harentius_blog.homepage.feed.number', $config['homepage']['feed']['number']);
        $container->setParameter('harentius_blog.list.posts_per_page', $config['list']['posts_per_page']);
    }
}

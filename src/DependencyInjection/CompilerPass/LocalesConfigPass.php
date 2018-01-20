<?php

namespace Harentius\BlogBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LocalesConfigPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $defaultLocale = $container->getParameter('kernel.default_locale');
        $locales = $container->getParameter('harentius_blog.locales');
        $supportedLocalesWithoutDefault = $locales;

        if (($key = array_search($defaultLocale, $supportedLocalesWithoutDefault, true)) !== false) {
            unset($supportedLocalesWithoutDefault[$key]);
        }

        $container->setParameter(
            'harentius_blog.supported_locales_without_default',
            implode('|', $supportedLocalesWithoutDefault)
        );
    }
}

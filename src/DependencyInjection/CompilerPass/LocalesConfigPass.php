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
        $locales = $container->getParameter('harentius_blog.locales');

        $container->setParameter(
            'harentius_blog.locales_requirement',
            implode('|', $locales)
        );
    }
}

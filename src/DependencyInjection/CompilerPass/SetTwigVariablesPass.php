<?php

namespace Harentius\BlogBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SetTwigVariablesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('twig');
        $definition
            ->addMethodCall(
                'addGlobal',
                ['image_previews_base_uri', $container->getParameter('harentius_blog.articles.image_previews_base_uri')]
            )->addMethodCall(
                'addGlobal',
                ['default_locale', $container->getParameter('kernel.default_locale')]
            )
        ;
    }
}

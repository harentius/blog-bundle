<?php

namespace Harentius\BlogBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SetTwigVariablesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('twig');
        $definition
            ->addMethodCall(
                'addGlobal',
                ['default_locale', $container->getParameter('kernel.default_locale')]
            )
        ;
    }
}

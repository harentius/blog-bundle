<?php

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\DependencyInjection\CompilerPass\SetTwigVariablesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HarentiusBlogBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container
            ->addCompilerPass(new SetTwigVariablesPass())
        ;
    }
}

<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\DependencyInjection\CompilerPass\SetTwigVariablesPass;
use Harentius\BlogBundle\HarentiusBlogBundle;
use Harentius\BlogBundle\Test\ContainerBuilderTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HarentiusBlogBundleTest extends ContainerBuilderTestCase
{
    public function testBuild(): void
    {
        $harentiusBlogBundle = new HarentiusBlogBundle();
        $containerBuilder = new ContainerBuilder();

        $harentiusBlogBundle->build($containerBuilder);

        $this->assertBuilderHasPass($containerBuilder, SetTwigVariablesPass::class);
    }
}

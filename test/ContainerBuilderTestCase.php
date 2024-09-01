<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerBuilderTestCase extends TestCase
{
    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $passInstance
     */
    public function assertBuilderHasPass(ContainerBuilder $containerBuilder, string $passInstance)
    {
        $passes = $containerBuilder->getCompiler()->getPassConfig()->getPasses();
        $passesClasses = [];

        foreach ($passes as $pass) {
            $passesClasses[$pass::class] = true;
        }

        $this->assertArrayHasKey($passInstance, $passesClasses);
    }
}

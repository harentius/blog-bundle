<?php

namespace Harentius\BlogBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalsExtension extends AbstractExtension implements GlobalsInterface
{
    private array $globals = [];

    public function getGlobals(): array
    {
        return $this->globals;
    }

    public function addGlobal(string $name, $value): void
    {
        $this->globals[$name] = $value;
    }
}

<?php

namespace Harentius\BlogBundle\Menu;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuTwigExtension extends AbstractExtension
{
    public function __construct(private readonly MenuBuilder $menuBuilder)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_main_menu_items', $this->menuBuilder->getMainMenuItems(...)),
        ];
    }
}

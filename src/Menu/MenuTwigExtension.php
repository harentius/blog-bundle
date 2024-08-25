<?php

namespace Harentius\BlogBundle\Menu;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuTwigExtension extends AbstractExtension
{
    /**
     * @var MenuBuilder
     */
    private $menuBuilder;

    public function __construct(MenuBuilder $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_main_menu_items', [$this->menuBuilder, 'getMainMenuItems']),
        ];
    }
}

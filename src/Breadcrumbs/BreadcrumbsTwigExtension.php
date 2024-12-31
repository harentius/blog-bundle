<?php

namespace Harentius\BlogBundle\Breadcrumbs;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BreadcrumbsTwigExtension extends AbstractExtension
{
    public function __construct(private readonly BreadCrumbsManager $breadCrumbsManager)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_breadcrumbs_items', $this->breadCrumbsManager->getBreadcrumbsItems(...)),
        ];
    }
}

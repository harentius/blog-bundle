<?php

namespace Harentius\BlogBundle\Breadcrumbs;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BreadcrumbsTwigExtension extends AbstractExtension
{
    /**
     * @var BreadCrumbsManager
     */
    private $breadCrumbsManager;

    public function __construct(BreadCrumbsManager $rating)
    {
        $this->breadCrumbsManager = $rating;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_breadcrumbs_items', [$this->breadCrumbsManager, 'getBreadcrumbsItems']),
        ];
    }
}

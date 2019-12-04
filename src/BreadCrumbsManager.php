<?php

declare(strict_types=1);

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Entity\Category;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class BreadCrumbsManager
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(Breadcrumbs $breadcrumbs, UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @param Category $category
     */
    public function buildCategory(Category $category): void
    {
        do {
            $this->breadcrumbs->prependItem(
                $category->getName(),
                $this->urlGenerator->generate('harentius_blog_category', ['slug' => $category->getSlugWithParents()])
            );
        } while ($category = $category->getParent());

        $this->breadcrumbs->prependItem('Homepage', $this->urlGenerator->generate('harentius_blog_homepage'));
    }
}

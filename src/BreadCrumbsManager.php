<?php

declare(strict_types=1);

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Entity\AbstractPost;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\Category;
use Harentius\BlogBundle\Entity\Tag;
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
                $this->urlGenerator->generate('harentius_blog_category', ['slug' => $category->getSlugWithParents()], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        } while ($category = $category->getParent());

        $this->prependHomepage();
    }

    /**
     * @param Tag $tag
     */
    public function buildTag(Tag $tag): void
    {
        $this->breadcrumbs->addItem($tag->getName());
        $this->prependHomepage();
    }

    /**
     * @param string $year
     * @param string|null $month
     */
    public function buildArchive(string $year, ?string $month = null): void
    {
        $this->breadcrumbs->addItem($year, $this->urlGenerator->generate('harentius_blog_archive_year', ['year' => $year], UrlGeneratorInterface::ABSOLUTE_URL));

        if ($month) {
            $this->breadcrumbs->addItem($month);
        }

        $this->prependHomepage();
    }

    public function buildPost(AbstractPost $post)
    {
        if ($post instanceof Article && $post->getCategory()) {
            $this->buildCategory($post->getCategory());
            $this->breadcrumbs->addItem($post->getTitle());
        } else {
            $this->breadcrumbs->addItem($post->getTitle());
            $this->prependHomepage();
        }
    }

    private function prependHomepage(): void
    {
        $this->breadcrumbs->prependItem('Homepage', $this->urlGenerator->generate('harentius_blog_homepage', [], UrlGeneratorInterface::ABSOLUTE_URL));
    }
}

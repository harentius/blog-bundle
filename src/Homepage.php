<?php

namespace Harentius\BlogBundle;

use Doctrine\ORM\QueryBuilder;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Page;
use Harentius\BlogBundle\Entity\PageRepository;

class Homepage
{
    public function __construct(private readonly ArticleRepository $articleRepository, private readonly PageRepository $pageRepository, private readonly ?string $categorySlug = null, private readonly ?string $homepageSlug = null)
    {
    }

    public function getFeedQueryBuilder(): QueryBuilder
    {
        return $this->articleRepository->findPublishedByCategorySlugQueryBuilder($this->categorySlug);
    }

    public function getPage(): ?Page
    {
        return $this->pageRepository->findOnePublishedBySlug($this->homepageSlug);
    }

    public function getUpdatedAt(): ?\DateTime
    {
        $page = $this->getPage();
        $updatedAt = null;

        if ($page) {
            $updatedAt = $page->getUpdatedAt();
        }

        $latestArticle = $this->articleRepository->findLatestPublishedByCategorySlug($this->categorySlug);

        if ($latestArticle && $latestArticle->getUpdatedAt() > $updatedAt) {
            $updatedAt = $latestArticle->getUpdatedAt();
        }

        return $updatedAt;
    }
}

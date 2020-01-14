<?php

namespace Harentius\BlogBundle;

use Doctrine\ORM\QueryBuilder;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Page;
use Harentius\BlogBundle\Entity\PageRepository;

class Homepage
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var string
     */
    private $categorySlug;

    /**
     * @var string
     */
    private $homepageSlug;

    /**
     * @param ArticleRepository $articleRepository
     * @param PageRepository $pageRepository
     * @param string $categorySlug
     * @param string $homepageSlug
     */
    public function __construct(
        ArticleRepository $articleRepository,
        PageRepository $pageRepository,
        ?string $categorySlug = null,
        ?string $homepageSlug = null
    ) {
        $this->articleRepository = $articleRepository;
        $this->categorySlug = $categorySlug;
        $this->homepageSlug = $homepageSlug;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function getFeedQueryBuilder(): QueryBuilder
    {
        return $this->articleRepository->findPublishedByCategorySlugQueryBuilder($this->categorySlug);
    }

    /**
     * @return Page|null
     */
    public function getPage(): ?Page
    {
        return $this->pageRepository->findOnePublishedBySlug($this->homepageSlug);
    }

    /**
     * @return \DateTime|null
     */
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

<?php

namespace Harentius\BlogBundle;

use Doctrine\ORM\Query;
use Harentius\BlogBundle\Entity\Article;
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
    private $category;

    /**
     * @var string
     */
    private $homepageSlug;

    /**
     * @param ArticleRepository $articleRepository
     * @param PageRepository $pageRepository
     * @param string $category
     * @param string $homepageSlug
     */
    public function __construct(ArticleRepository $articleRepository, PageRepository $pageRepository, $category, $homepageSlug)
    {
        $this->articleRepository = $articleRepository;
        $this->category = $category;
        $this->homepageSlug = $homepageSlug;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return Query
     */
    public function getFeed()
    {
        return $this->articleRepository->findPublishedByCategorySlugLimitedQuery($this->category);
    }

    /**
     * @return Page|null
     */
    public function getPage()
    {
        return $this->pageRepository->findOneBy([
            'slug' => $this->homepageSlug,
            'isPublished' => true
        ]);
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        $page = $this->getPage();
        $updatedAt = null;

        if ($page) {
            $updatedAt = $page->getUpdatedAt();
        }

        /** @var Article $article */
        foreach ($this->getFeed()->execute() as $article) {
            if (($articleUpdatedAt = $article->getUpdatedAt()) > $updatedAt) {
                $updatedAt = $articleUpdatedAt;
            }
        }

        return $updatedAt;
    }
}

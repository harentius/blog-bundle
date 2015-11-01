<?php

namespace Harentius\BlogBundle;

use Doctrine\Common\Cache\CacheProvider;
use Harentius\BlogBundle\Entity\ArticleRepository;

class Statistics
{
    /**
     * @var CacheProvider
     */
    protected $cache;

    /**
     * @var int
     */
    protected $cacheLifetime;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * Statistics constructor.
     * @param CacheProvider $cache
     * @param $cacheLifetime
     * @param ArticleRepository $articleRepository
     */
    public function __construct(CacheProvider $cache, $cacheLifetime, ArticleRepository $articleRepository)
    {
        $this->cache = $cache;
        $this->cacheLifetime = $cacheLifetime;
        $this->articleRepository = $articleRepository;
        $this->getAll();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $key = 'statistics';

        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $statistics = $this->articleRepository->findStatistics();
        $mostPopularArticle = $this->articleRepository->findMostPopular();
        $statistics['mostPopularArticleData'] = [
            'slug' => $mostPopularArticle->getSlug(),
            'title' => $mostPopularArticle->getTitle(),
            'viewsCount' => $mostPopularArticle->getViewsCount(),
        ];
        $this->cache->save($key, $statistics, $this->cacheLifetime);

        return $statistics;
    }
}

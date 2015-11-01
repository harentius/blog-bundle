<?php

namespace Harentius\BlogBundle;

use Doctrine\Common\Cache\CacheProvider;
use Eko\FeedBundle\Feed\FeedManager;
use Harentius\BlogBundle\Entity\ArticleRepository;

class Feed
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var FeedManager
     */
    private $feedManager;

    /**
     * @var CacheProvider
     */
    private $cache;

    /**
     * @param ArticleRepository $articleRepository
     * @param FeedManager $feedManager
     * @param CacheProvider $cache
     */
    public function __construct(
        ArticleRepository $articleRepository,
        FeedManager $feedManager,
        CacheProvider $cache
    ) {
        $this->articleRepository = $articleRepository;
        $this->feedManager = $feedManager;
        $this->cache = $cache;
    }

    /**
     * @return string
     */
    public function get()
    {
        $key = 'feed';

        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $articles = $this->articleRepository->findPublishedOrderedByPublishDate();
        $feed = $this->feedManager->get('article');
        $feed->addFromArray($articles);
        $renderedFeed = $feed->render('rss');
        $this->cache->save($key, $renderedFeed);

        return $renderedFeed;
    }
}

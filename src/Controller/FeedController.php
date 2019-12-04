<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Eko\FeedBundle\Feed\FeedManager;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;

class FeedController
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
     * @param ArticleRepository $articleRepository
     * @param FeedManager $feedManager
     */
    public function __construct(
        ArticleRepository $articleRepository,
        FeedManager $feedManager
    ) {
        $this->articleRepository = $articleRepository;
        $this->feedManager = $feedManager;
    }

    /**
     * @return Response
     */
    public function feed(): Response
    {
        $articles = $this->articleRepository->findPublishedOrderedByPublishDate();
        $feed = $this->feedManager->get('article');
        $feed->addFromArray($articles);

        return new Response($feed->render('rss'));
    }
}

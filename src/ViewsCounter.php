<?php

namespace Harentius\BlogBundle;

use Doctrine\ORM\EntityManager;
use Harentius\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ViewsCounter
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param SessionInterface $session
     * @param EntityManager $em
     */
    public function __construct(SessionInterface $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @param Article $article
     */
    public function processArticle(Article $article)
    {
        $viewedArticles = $this->session->get('viewedArticles', []);
        $articleId = $article->getId();

        if (isset($viewedArticles[$articleId])) {
            return;
        }

        $viewedArticles[$articleId] = true;
        $article->increaseViewsCount();
        $this->session->set('viewedArticles', $viewedArticles);
        $this->em->flush($article);
    }
}

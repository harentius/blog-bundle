<?php

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ViewsCounter
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
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
    }
}

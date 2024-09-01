<?php

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\RequestStack;

class ViewsCounter
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param Article $article
     */
    public function processArticle(Article $article)
    {
        $viewedArticles = $this->requestStack->getSession()->get('viewedArticles', []);
        $articleId = $article->getId();

        if (isset($viewedArticles[$articleId])) {
            return;
        }

        $viewedArticles[$articleId] = true;
        $article->increaseViewsCount();
        $this->requestStack->getSession()->set('viewedArticles', $viewedArticles);
    }
}

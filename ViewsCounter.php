<?php

namespace Harentius\BlogBundle;

use Doctrine\ORM\EntityManager;
use Harentius\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ViewsCounter
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param RequestStack $requestStack
     * @param EntityManager $em
     */
    public function __construct(RequestStack $requestStack, EntityManager $em)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
    }

    /**
     * @param Article $article
     */
    public function processArticle(Article $article)
    {
        $session = $this->request->getSession();
        $viewedArticles = $session->get('viewedArticles', []);
        $articleId = $article->getId();

        if (!isset($viewedArticles[$articleId] )) {
            $viewedArticles[$articleId] = true;
            $article->increaseViewsCount();
            $session->set('viewedArticles', $viewedArticles);
            $this->em->flush($article);
        }
    }
}

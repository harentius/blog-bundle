<?php

namespace Harentius\BlogBundle;

use Harentius\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class Rating
{
    public const TYPE_LIKE = 'like';
    public const TYPE_DISLIKE = 'dislike';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param Article $article
     * @param string $type
     * @return Response
     */
    public function rate(Article $article, $type = self::TYPE_LIKE): Response
    {
        $response = new Response();

        if ($type === self::TYPE_LIKE) {
            $article->increaseLikesCount();
        } elseif ($type === self::TYPE_DISLIKE) {
            $article->increaseDisLikesCount();
        }

        $this->addToRated($response, $article, $type);

        return $response;
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isLiked(Article $article): bool
    {
        return in_array($article->getId(), $this->getCookie('harentius_blog_articles_like'), true);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isDisLiked(Article $article): bool
    {
        return in_array($article->getId(), $this->getCookie('harentius_blog_articles_dislike'), true);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isRated(Article $article): bool
    {
        return $this->isLiked($article)
            || $this->isDisLiked($article)
        ;
    }

    /**
     * @param Response $response
     * @param Article $article
     * @param string $type
     */
    private function addToRated(Response $response, Article $article, $type): void
    {
        $articleId = $article->getId();
        $key = "harentius_blog_articles_{$type}";
        $rated = $this->getCookie($key);

        if (!in_array($articleId, $rated, true)) {
            $rated[] = $articleId;
            $response->headers->setCookie(new Cookie($key, json_encode($rated)));
        }
    }

    /**
     * @return Request
     */
    private function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @param string $key
     * @return array
     */
    private function getCookie(string $key): array
    {
        return json_decode($this->getRequest()->cookies->get($key, '[]'));
    }
}

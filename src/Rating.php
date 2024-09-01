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

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @param string $type
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

    public function isLiked(Article $article): bool
    {
        return in_array($article->getId(), $this->getCookie('harentius_blog_articles_like'), true);
    }

    public function isDisLiked(Article $article): bool
    {
        return in_array($article->getId(), $this->getCookie('harentius_blog_articles_dislike'), true);
    }

    public function isRated(Article $article): bool
    {
        return $this->isLiked($article)
            || $this->isDisLiked($article)
        ;
    }

    /**
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

    private function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    private function getCookie(string $key): array
    {
        return json_decode($this->getRequest()->cookies->get($key, '[]'));
    }
}

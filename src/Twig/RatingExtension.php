<?php

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RatingExtension extends AbstractExtension
{
    public function __construct(private readonly Rating $rating)
    {
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('is_article_liked', $this->isArticleLiked(...)),
            new TwigFunction('is_article_disliked', $this->isArticleDisLiked(...)),
            new TwigFunction('is_article_rated', $this->isArticleRated(...)),
        ];
    }

    public function isArticleLiked(Article $article): bool
    {
        return $this->rating->isLiked($article);
    }

    public function isArticleDisLiked(Article $article): bool
    {
        return $this->rating->isDisLiked($article);
    }

    public function isArticleRated(Article $article): bool
    {
        return $this->rating->isRated($article);
    }
}

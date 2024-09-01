<?php

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RatingExtension extends AbstractExtension
{
    /**
     * @param Rating $rating
     */
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

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleLiked(Article $article)
    {
        return $this->rating->isLiked($article);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleDisLiked(Article $article)
    {
        return $this->rating->isDisLiked($article);
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isArticleRated(Article $article)
    {
        return $this->rating->isRated($article);
    }
}

<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RateController extends AbstractController
{
    /**
     * @var Rating
     */
    private $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * @param Article $article
     * @param string $type
     * @return Response
     */
    public function rate(Article $article, $type = 'like')
    {
        return $this->rating->rate(new Response(), $article, $type);
    }
}

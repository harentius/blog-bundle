<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RateController
{
    public function __construct(private readonly Rating $rating, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $type
     */
    public function __invoke(Article $article, $type = 'like'): Response
    {
        if ($this->rating->isRated($article)) {
            throw new AccessDeniedHttpException('You already voted for this article');
        }

        $response = $this->rating->rate($article, $type);
        $this->entityManager->flush();

        return $response;
    }
}

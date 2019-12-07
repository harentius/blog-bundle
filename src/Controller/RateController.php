<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RateController extends AbstractController
{
    /**
     * @var Rating
     */
    private $rating;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(Rating $rating, EntityManagerInterface $entityManager)
    {
        $this->rating = $rating;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Article $article
     * @param string $type
     * @return Response
     */
    public function rate(Article $article, $type = 'like'): Response
    {
        if ($this->rating->isRated($article)) {
            throw new AccessDeniedHttpException('You already voted for this article');
        }

        $response = $this->rating->rate($article, $type);
        $this->entityManager->flush();

        return $response;
    }
}

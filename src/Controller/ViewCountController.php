<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\ViewsCounter;
use Symfony\Component\HttpFoundation\JsonResponse;

class ViewCountController
{
    /**
     * @param ViewsCounter $viewsCounter
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private readonly ViewsCounter $viewsCounter, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    public function __invoke(Article $article): JsonResponse
    {
        $this->viewsCounter->processArticle($article);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}

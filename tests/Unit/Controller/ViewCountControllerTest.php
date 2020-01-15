<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Controller\ViewCountController;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\ViewsCounter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ViewCountControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $article = new Article();
        $viewsCounter = $this->createMock(ViewsCounter::class);
        $viewsCounter
            ->expects($this->once())
            ->method('processArticle')
            ->with($article)
        ;
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('flush')
        ;
        $viewCountController = new ViewCountController($viewsCounter, $entityManager);

        $response = $viewCountController($article);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}

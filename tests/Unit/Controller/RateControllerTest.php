<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Harentius\BlogBundle\Controller\RateController;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RateControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $rating = $this->createMock(Rating::class);
        $rating
            ->method('rate')
            ->willReturn(new Response())
        ;
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())
            ->method('flush')
        ;
        $article = new Article();

        $rateController = $this->createRateController($rating, $entityManager);
        $response = $rateController($article);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testInvokeWithException(): void
    {
        $rating = $this->createMock(Rating::class);
        $rating
            ->method('isRated')
            ->willReturn(true)
        ;
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $article = new Article();

        $rateController = $this->createRateController($rating, $entityManager);
        $this->expectException(AccessDeniedHttpException::class);
        $rateController($article);
    }

    private function createRateController(Rating $rating, EntityManagerInterface $entityManager): RateController
    {
        return new RateController($rating, $entityManager);
    }
}

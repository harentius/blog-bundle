<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Rating;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RatingTest extends TestCase
{
    public function testRateLike(): void
    {
        $rating = $this->createRating();

        $article = new Article();

        $rating->rate($article, Rating::TYPE_LIKE);
        $this->assertSame(1, $article->getLikesCount());
    }

    public function testRateDisLike(): void
    {
        $rating = $this->createRating();

        $article = new Article();

        $rating->rate($article, Rating::TYPE_DISLIKE);
        $this->assertSame(1, $article->getDisLikesCount());
    }

    private function createRating(): Rating
    {
        $request = new Request();
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        return new Rating($requestStack);
    }
}

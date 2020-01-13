<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Doctrine\Common\Cache\ArrayCache;
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

    public function testIsRated(): void
    {
        $rating = $this->createRating();

        $article = new Article();

        $this->assertFalse($rating->isRated($article));
        $rating->rate($article, Rating::TYPE_LIKE);
        $this->assertTrue($rating->isRated($article));
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
        $cacheProvider = new ArrayCache();

        return new Rating($requestStack, $cacheProvider);
    }
}

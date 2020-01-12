<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\ViewsCounter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ViewsCounterTest extends TestCase
{
    public function testProcessArticleAddToProcessed(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session
            ->expects($this->once())
            ->method('set')
            ->with('viewedArticles', [123 => true])
        ;
        $viewsCounter = new ViewsCounter($session);
        $article = $this->createArticle();

        $viewsCounter->processArticle($article);

        $this->assertSame(1, $article->getViewsCount());
    }

    public function testProcessArticleDoNotIncreaseViewsCountIfViewStoredInSession(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session
            ->method('get')
            ->willReturn([123 => true])
        ;
        $viewsCounter = new ViewsCounter($session);
        $article = $this->createArticle();

        $viewsCounter->processArticle($article);

        $this->assertSame(0, $article->getViewsCount());
    }

    /**
     * @return Article|MockObject
     */
    private function createArticle(): Article
    {
        /** @var Article|MockObject $article */
        $article = $this
            ->getMockBuilder(Article::class)
            ->onlyMethods(['getId'])
            ->getMock()
        ;
        $article->method('getId')->willReturn(123);

        return $article;
    }
}

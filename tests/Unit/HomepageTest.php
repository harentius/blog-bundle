<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\ArticleRepository;
use Harentius\BlogBundle\Entity\Page;
use Harentius\BlogBundle\Entity\PageRepository;
use Harentius\BlogBundle\Homepage;
use PHPUnit\Framework\TestCase;

class HomepageTest extends TestCase
{
    public function testGetFeedQueryBuilder(): void
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository
            ->expects($this->once())
            ->method('findPublishedByCategorySlugQueryBuilder')
            ->with('category_slug')
        ;
        $pageRepository = $this->createMock(PageRepository::class);
        $homepage = $this->createHomepage($articleRepository, $pageRepository);

        $homepage->getFeedQueryBuilder();
    }

    public function testGetPage(): void
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $pageRepository = $this->createMock(PageRepository::class);
        $pageRepository
            ->expects($this->once())
            ->method('findOnePublishedBySlug')
            ->with('homepage_slug')
        ;
        $homepage = $this->createHomepage($articleRepository, $pageRepository);

        $homepage->getPage();
    }

    public function testGetUpdatedAtReturnPageDate(): void
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $page = new Page();
        $page->setUpdatedAt(new \DateTime('2018/12/21 00:00:00'));
        $pageRepository = $this->createMock(PageRepository::class);
        $pageRepository
            ->method('findOnePublishedBySlug')
            ->willReturn($page)
        ;
        $homepage = $this->createHomepage($articleRepository, $pageRepository);

        $updatedAt = $homepage->getUpdatedAt();
        $this->assertEquals(new \DateTime('2018/12/21 00:00:00'), $updatedAt);
    }

    public function testGetUpdatedAtReturnArticleDate(): void
    {
        $article = new Article();
        $article->setUpdatedAt(new \DateTime('2018/12/22 00:00:00'));
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository
            ->method('findLatestPublishedByCategorySlug')
            ->willReturn($article)
        ;
        $page = new Page();
        $page->setUpdatedAt(new \DateTime('2018/12/21 00:00:00'));
        $pageRepository = $this->createMock(PageRepository::class);
        $pageRepository
            ->method('findOnePublishedBySlug')
            ->willReturn($page)
        ;
        $homepage = $this->createHomepage($articleRepository, $pageRepository);

        $updatedAt = $homepage->getUpdatedAt();
        $this->assertEquals(new \DateTime('2018/12/22 00:00:00'), $updatedAt);
    }

    private function createHomepage(
        ArticleRepository $articleRepository,
        PageRepository $pageRepository,
    ): Homepage {
        return new Homepage($articleRepository, $pageRepository, 'category_slug', 'homepage_slug');
    }
}

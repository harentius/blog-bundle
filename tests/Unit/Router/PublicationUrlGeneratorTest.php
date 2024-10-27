<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Router;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Router\PublicationUrlGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicationUrlGeneratorTest extends TestCase
{
    public function testGenerateUrlDefaultLocale(): void
    {
        $urlGenerator = $this->createUrlGeneratorInterfaceMock();
        $urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('harentius_blog_show_default', ['slug' => 'article_slug'])
        ;

        $publicationUrlGenerator = $this->createPublicationUrlGenerator($urlGenerator);
        $article = new Article();
        $article->setSlug('article_slug');

        $publicationUrlGenerator->generateUrl($article, 'uk');
    }

    public function testGenerateUrlNotDefaultLocale(): void
    {
        $urlGenerator = $this->createUrlGeneratorInterfaceMock();
        $urlGenerator
            ->expects($this->once())
            ->method('generate')
            ->with('harentius_blog_show_default', ['slug' => 'article_slug'])
        ;

        $publicationUrlGenerator = $this->createPublicationUrlGenerator($urlGenerator);
        $article = new Article();
        $article->setSlug('article_slug');

        $publicationUrlGenerator->generateUrl($article, 'en');
    }

    private function createPublicationUrlGenerator(UrlGeneratorInterface $urlGenerator): PublicationUrlGenerator
    {
        return new PublicationUrlGenerator($urlGenerator);
    }

    /**
     * @return UrlGeneratorInterface|MockObject
     */
    private function createUrlGeneratorInterfaceMock(): UrlGeneratorInterface
    {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator
            ->method('generate')
            ->willReturn('url')
        ;

        return $urlGenerator;
    }
}

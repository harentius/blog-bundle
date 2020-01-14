<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Eko\FeedBundle\Feed\FeedManager;
use Eko\FeedBundle\Formatter\RssFormatter;
use Harentius\BlogBundle\Controller\FeedController;
use Harentius\BlogBundle\Entity\ArticleRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FeedControllerTest extends TestCase
{
    public function testInvoke(): void
    {
        $articleRepository = $this->createMock(ArticleRepository::class);
        $articleRepository->method('findPublishedOrderedByPublishDate')->willReturn([]);
        $feedController = new FeedController($articleRepository, $this->createFeedManager());
        $response = $feedController();

        $this->assertInstanceOf(Response::class, $response);
    }

    private function createFeedManager(): FeedManager
    {
        $router = $this->createMock(RouterInterface::class);

        $feedManager = new FeedManager($router, [
            'feeds' => [
                'article' => [
                    'title' => 'Title',
                    'description' => 'Description',
                    'link' => ['route_name' => 'harentius_blog_homepage', 'route_params' => []],
                ],
            ],
        ], [
            'rss' => new RssFormatter($this->createMock(TranslatorInterface::class)),
        ]);

        return $feedManager;
    }
}

<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Tests\Unit\Controller;

use Harentius\BlogBundle\BreadCrumbsManager;
use Harentius\BlogBundle\Controller\ShowController;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\Page;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ShowControllerTest extends TestCase
{
    public function testInvokeWithArticle(): void
    {
        $article = new Article();
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Show/article.html.twig', [
                'entity' => $article,
            ])
        ;
        $showController = $this->createShowController($twig);
        $response = $showController($article);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testInvokeWithPage(): void
    {
        $page = new Page();
        $twig = $this->createMock(Environment::class);
        $twig
            ->expects($this->once())
            ->method('render')
            ->with('@HarentiusBlog/Show/page.html.twig', [
                'entity' => $page,
            ])
        ;
        $showController = $this->createShowController($twig);
        $response = $showController($page);
        $this->assertInstanceOf(Response::class, $response);
    }

    private function createShowController(Environment $twig): ShowController
    {
        $breadCrumbsManager = $this->createMock(BreadCrumbsManager::class);
        $controller = new ShowController($breadCrumbsManager);
        $container = new Container();
        $container->set('twig', $twig);
        $controller->setContainer($container);

        return $controller;
    }
}
